<?php
namespace App\Jobs;

use App\Models\PaymentFiles;
use App\Models\PaymentHistory;
use App\Models\PayrolSummary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SoftPayInitiation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $fileId;
    /**
     * Create a new job instance.
     */
    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $paymentFile = PaymentFiles::find($this->fileId);
        \Log::info($paymentFile);

        if (isset($paymentFile)) {
            // Fetch records from the database
            $beneficiaries = PaymentHistory::where("workgroup_id", $paymentFile->workgroup_id)
                ->where("file_id", $paymentFile->id)
                ->where("amount", ">", 0)
                ->get()->map(function ($beneficiary) use ($paymentFile) {
                return [
                    'bankId'        => $beneficiary->bank_id,
                    'accountNumber' => $beneficiary->account_number,
                    'accountName'   => $beneficiary->account_name,
                    'amount'        => $beneficiary->amount,
                    'payRun'        => $beneficiary->narration,
                    'payPeriod'     => $paymentFile->period,
                    'personId'      => $beneficiary->unique_id,
                    'bankName'      => $beneficiary->bank_name,
                ];
            })->toArray();
            // \Log::info("Below We Log Beneficiaries");
            // \Log::info($beneficiaries);

            // 'isVirtualAccount' => true,
            $data = [
                'sourceAccountId' => (int) env("SOFTPAY_SOURCE_ACCOUNT"),
                'memo'            => $paymentFile->memo,
                'transactionType' => 'instant',
                'beneficiaries'   => $beneficiaries,
            ];

            // \Log::info("Below We Log the data we are sending to Soft Alliance");
            // \Log::info($data);

            $response = Http::timeout(800)->accept('application/json')->withHeaders([
                'client-id'   => env('SOFTPAY_CLIENT_ID'),
                'x-api-key'   => env('SOFTPAY_API_KEY'),
                'x-api-token' => env('SOFTPAY_API_TOKEN'),
                'business-id' => env('SOFTPAY_UUID'),
            ])->post(env('SOFTPAY_BASE_URL') . '/payments', $data);

            // \Log::info("----------------------------------------------------------------------");
            // \Log::info("Logging Raw Response from Soft Alliance Initiation.");
            // \Log::info($response);
            // \Log::info("----------------------------------------------------------------------");

            if ($response->successful()) {
                try {

                    // \Log::info("Below we log the response we get from Soft Alliance during payment initiation");
                    // \Log::info($response->json());

                    $responseData = $response->collect("data");
                    // \Log::info("Below we log the response data");
                    // \Log::info($responseData);

                    $paymentFile->reference        = $responseData["reference"];
                    $paymentFile->amount_debited   = $responseData["totalDebitAmount"];
                    $paymentFile->trx_charge       = $responseData["processingFee"];
                    $paymentFile->trx_amount       = $responseData["totalAmount"];
                    $paymentFile->schedule_control = "updating ongoing";
                    $paymentFile->save();

                    $this->authorizePayment($paymentFile->reference);

                } catch (\Exception $e) {
                    \Log::info("Error Log During Record Keeping When Initiation is Successful");
                    \Log::info($e->getMessage());
                }

            } else {
                \Log::info("----------------------------------------------------------------------");
                try {

                    // \Log::info("Below we log the response we get from Soft Alliance during payment initiation");
                    // Handle error
                    \Log::info("Below we log the error response we get from Soft Alliance during payment initiation");
                    \Log::error($response->json());

                    $message = $response->collect("message")[0];
                    \Log::error($message);

                    $comment                       = "Transaction Failed During Payment Initiation";
                    $paymentFile->validation       = "failed";
                    $paymentFile->processing       = "failed";
                    $paymentFile->schedule_control = "feedback received";
                    $paymentFile->softpay_comment  = $message;
                    $paymentFile->save();

                    if ($paymentFile->classification == "payrol") {
                        $payrol         = PayrolSummary::find($paymentFile->payrol_id);
                        $payrol->status = "failed";
                        $payrol->save();
                    }

                    PaymentHistory::where('file_id', $paymentFile->id)
                        ->update(['validation' => 'failed', 'processing' => 'failed', "status" => "Failed", "comment" => $comment]);

                    \Log::info("Transaction Failed");
                } catch (\Exception $e) {
                    \Log::info("Error Log During Record Keeping When Initiation Failed");
                    \Log::info($e->getMessage());
                }
            }

        }
    }

    public function authorizePayment($reference)
    {
        $paymentFile = PaymentFiles::where("reference", $reference)->where("schedule_control", "updating ongoing")->first();
        if (isset($paymentFile)) {

            $data = [
                'reference' => $reference,
                'pin'       => env("SOFTPAY_PIN"),
            ];

            $response = Http::timeout(800)->accept('application/json')->withHeaders([
                'client-id'   => env('SOFTPAY_CLIENT_ID'),
                'x-api-key'   => env('SOFTPAY_API_KEY'),
                'x-api-token' => env('SOFTPAY_API_TOKEN'),
                'business-id' => env('SOFTPAY_UUID'),
            ])->post(env('SOFTPAY_BASE_URL') . '/payments/authorize', $data);

            // \Log::info("Logging Raw Response from Soft Alliance Authorization.");
            // \Log::info($response);

            if ($response->successful()) {
                try {
                    // \Log::info("Below we log the response we get from Soft Alliance during payment authorization");
                    // \Log::info($response->json());

                    $paymentFile->validation       = "completed";
                    $paymentFile->processing       = "in-progress";
                    $paymentFile->schedule_control = "schedule closed";
                    $paymentFile->save();

                    PaymentHistory::where('file_id', $paymentFile->id)
                        ->update(['validation' => 'in-progress', 'processing' => 'in-progress']);

                    \Log::info("Jesus Bu Eze");
                } catch (\Exception $e) {
                    \Log::info("Error Log During Record Keeping When Authorization is Successful");
                    \Log::info($e->getMessage());
                }

            } else {
                try {
                    \Log::info("Below we log the error response we get from Soft Alliance during payment authorization");
                    \Log::error($response->json());

                    $message = $response->collect("message")[0];
                    \Log::error($message);

                    $comment                       = "Transaction Failed During Payment Authorization";
                    $paymentFile->validation       = "failed";
                    $paymentFile->processing       = "failed";
                    $paymentFile->schedule_control = "feedback received";
                    $paymentFile->softpay_comment  = $message;
                    $paymentFile->save();

                    if ($paymentFile->classification == "payrol") {
                        $payrol         = PayrolSummary::find($paymentFile->payrol_id);
                        $payrol->status = "failed";
                        $payrol->save();
                    }

                    PaymentHistory::where('file_id', $paymentFile->id)
                        ->update(['validation' => 'failed', 'processing' => 'failed', "status" => "Failed", "comment" => $comment]);

                    \Log::info("Transaction Failed");
                } catch (\Exception $e) {
                    \Log::info("Error Log During Record Keeping When Authorization Failed");
                    \Log::info($e->getMessage());
                }
            }
        }
    }
}
