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

class CoralPayInitiation implements ShouldQueue
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
            //Get total amount
            $totalAmount = PaymentHistory::where("workgroup_id", $paymentFile->workgroup_id)
                ->where("file_id", $paymentFile->id)
                ->get()
                ->sum(function ($payment) {
                    return round($payment->amount, 2); // Round each amount before summing
                });

            \Log::info("Below we log the Total Transction Amount Computed");
            \Log::info($totalAmount);

            // Fetch records from the database
            $beneficiaries = PaymentHistory::where("workgroup_id", $paymentFile->workgroup_id)
                ->where("file_id", $paymentFile->id)
                ->get()->map(function ($beneficiary) use ($paymentFile) {
                return [
                    'creditAccount'     => $beneficiary->account_number, //"1780004070",
                    'creditAccountName' => $beneficiary->account_name,   //"Ake Mobolaji Temabor",
                    'creditBankCode'    => $beneficiary->bank_code,      //"999998",
                    'narration'         => $beneficiary->narration,
                    'amount'            => round($beneficiary->amount, 2),
                    'itemTraceId'       => $beneficiary->trace_id,
                ];
            })->toArray();
            \Log::info("Below We Log Beneficiaries");
            \Log::info($beneficiaries);

            $getPaymentSignature = $this->getPaymentConfig();

            $data = [
                'traceId'         => $getPaymentSignature["data"]["traceId"],
                'totalAmount'     => round($totalAmount, 2),
                'signature'       => $getPaymentSignature["data"]["signature"],
                'timestamp'       => $getPaymentSignature["data"]["timestamp"],
                'transactionList' => $beneficiaries,
            ];

            \Log::info("Below We Log the data we are sending to Coral Pay");
            \Log::info($data);

            $response = Http::timeout(800)->accept('application/json')->withHeaders([
                'Authorization' => 'Bearer ' . env('CORALPAY_TOKEN'),
            ])->post(env('CORALPAY_BASE_URL') . '/BatchPost', $data);

            if ($response->successful()) {
                \Log::info("Below we log the response we get from Coral Pay after the handshake");
                \Log::info($response->json());
                $responseData = $response->json();
                if ($responseData["responseHeader"]["responseCode"] == "00"
                    && $responseData["responseHeader"]["responseMessage"] == "success") {
                    $paymentFile->trace_id         = $responseData["traceId"];
                    $paymentFile->batch_id         = $responseData["batchId"];
                    $paymentFile->signature        = $getPaymentSignature["data"]["signature"];
                    $paymentFile->timestamp        = $getPaymentSignature["data"]["timestamp"];
                    $paymentFile->schedule_control = "schedule closed";
                    $paymentFile->amount_debited   = $responseData["amountDebited"];
                    $paymentFile->trx_amount       = $responseData["transactionAmount"];
                    $paymentFile->trx_charge       = $responseData["transactionCharge"];
                    $paymentFile->vat              = $responseData["vat"];
                    $paymentFile->save();

                    PaymentHistory::where('file_id', $paymentFile->id)
                        ->update(['validation' => 'in-progress', 'processing' => 'in-progress']);

                    \Log::info("Jesus Bu Eze");
                } else {
                    $comment                       = $responseData["responseHeader"]["responseMessage"];
                    $paymentFile->trace_id         = $responseData["traceId"];
                    $paymentFile->validation       = "failed";
                    $paymentFile->processing       = "failed";
                    $paymentFile->schedule_control = "feedback received";
                    $paymentFile->save();

                    if ($paymentFile->classification == "payrol") {
                        $payrol         = PayrolSummary::find($paymentFile->payrol_id);
                        $payrol->status = "failed";
                        $payrol->save();
                    }

                    PaymentHistory::where('file_id', $paymentFile->id)
                        ->update(['validation' => 'failed', 'processing' => 'failed', "status" => "Failed", "comment" => $comment]);

                    \Log::info("Transaction Failed");
                }

            } else {
                \Log::info("Something done happen o");
                \Log::error($response->json());
            }
        }
    }

    public function getPaymentConfig()
    {
        $now         = strtotime(now());
        $traceId     = "FASTMITA_{$now}";
        $timestamp   = time();
        $merchantId  = env("CORALPAY_MERCHANT_ID");
        $key         = env("CORALPAY_KEY");
        $credentials = "{$merchantId}{$traceId}{$timestamp}{$key}";
        return [
            'status_code' => (int) 200,
            'status'      => "Successful",
            'data'        => [
                'traceId'   => $traceId,
                'timestamp' => $timestamp,
                'signature' => hash('sha512', $credentials),
            ],
        ];
    }
}
