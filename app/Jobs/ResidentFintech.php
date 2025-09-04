<?php
namespace App\Jobs;

use App\Models\PaymentBatch;
use App\Models\PaymentHistory;
use App\Models\ResidentToken;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ResidentFintech implements ShouldQueue
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
        $paymentFile = PaymentBatch::find($this->fileId);

        if (! empty($paymentFile)) {

            // \Log::info($paymentFile);

            $token = $this->generateToken();

            if (! empty($token)) {
                \Log::info("Token Generated Successfully.");

                $scheduleCreation = $this->createPaymentSchedule($this->fileId, $token);

                if (! empty($scheduleCreation)) {
                    \Log::info("Payment Schedule Created Successfully.");
                    // \Log::info($scheduleCreation);
                    $paymentFile->schedule_id      = $scheduleCreation["scheduleId"];
                    $paymentFile->reference        = $scheduleCreation["referenceNo"];
                    $paymentFile->our_reference    = $scheduleCreation["ourReference"];
                    $paymentFile->schedule_control = "schedule created";
                    $paymentFile->save();

                    $addTransactions = $this->addTransactions($this->fileId, $token);
                    if (! empty($addTransactions)) {
                        // \Log::info($addTransactions);
                        \Log::info("Transactions Added Successfully.");

                        $closeSchedule = $this->closeSchedule($this->fileId, $token);
                        if (! empty($closeSchedule)) {
                            // \Log::info($closeSchedule);
                            \Log::info("Payment Schedule Closed Successfully.");
                        } else {
                            \Log::error("Closing Schedule Failed");
                        }

                    } else {
                        \Log::error("Adding Transactions Failed");
                    }
                } else {
                    \Log::error("Schedule Creation Failed");
                }

            } else {
                \Log::error("Token Generation Failed");
            }
        } else {
            \Log::error("Payment Batch Not Found");
        }
    }

    public function generateToken()
    {

        try {

            $residentToken = ResidentToken::where("status", "active")->first();

            if (! empty($residentToken)) {
                \Log::info("Re-using existing valid Token");
                return $residentToken->token;
            } else {

                $data = [
                    'client_id'     => env('RESIDENT_CLIENT_ID'),
                    'client_secret' => env('RESIDENT_CLIENT_SECRET'),
                ];

                $response = Http::timeout(500)->accept('application/json')
                    ->post(env('RESIDENT_BASE_URL') . '/generatetoken', $data);

                $responseData = $response->json();
                if (isset($responseData)) {

                    $residentToken                   = new ResidentToken;
                    $residentToken->token            = $responseData["Bearer"]["token"];
                    $residentToken->token_expiration = Carbon::now()->addHours(1);
                    $residentToken->save();

                    \Log::info("Former Token Expired. Generating and using new Token");
                    return $responseData["Bearer"]["token"];
                } else {
                    \Log::info($responseData);
                    return null;
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }

    public function createPaymentSchedule($fileId, $token)
    {
        $paymentFile = PaymentBatch::find($fileId);

        $reference = $this->generateReference();

        $data = [
            "title"              => $paymentFile->file_name,
            "debitBankCode"      => env('RESIDENT_DEBIT_BANK'),
            "debitAccountNumber" => env('RESIDENT_ACCOUNT_NUMBER'),
            "debitDescription"   => "Fast Pay Kogi " . $paymentFile->memo,
            "paymentMode"        => "NEFT",
            "referenceNo"        => $reference,
            "scheduleType"       => "Csv",
        ];

        $response = Http::timeout(500)->accept('application/json')->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(env('RESIDENT_BASE_URL') . '/createschedule', $data);

        $responseData = $response->json();
        // \Log::info($responseData);
        if (isset($responseData) && isset($responseData["data"]["scheduleId"])) {
            return [
                "scheduleId"   => $responseData["data"]["scheduleId"],
                "referenceNo"  => $responseData["data"]["referenceNo"],
                "ourReference" => $reference,
            ];
        } else {
            \Log::info($responseData);
            return null;
        }
    }

    public function addTransactions($fileId, $token)
    {
        $paymentFile = PaymentBatch::find($fileId);

        $beneficiaries = PaymentHistory::where("batch_id", $paymentFile->id)
            ->get()->map(function ($beneficiary) use ($paymentFile) {
            return [
                'bankCode'      => $beneficiary->bank_code,
                'accountNumber' => $beneficiary->account_number,
                'narration'     => $beneficiary->narration,
                'amount'        => (string) number_format(round($beneficiary->amount, 2), 2),
                'accountName'   => $beneficiary->account_name,
                'serialNo'      => $beneficiary->trace_id,
            ];

        })->toArray();

        $data = [
            'scheduleId' => $paymentFile->schedule_id,
            'batch'      => 1,
            'data'       => $beneficiaries,
        ];

        $response = Http::timeout(800)->accept('application/json')->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(env('RESIDENT_BASE_URL') . '/addtransactions', $data);

        $responseData = $response->json();
        if (isset($responseData) && isset($responseData["success"]) && $responseData["success"] === true) {
            return $responseData["data"];
        } else {
            \Log::info($responseData);
            return null;
        }

    }

    public function closeSchedule($fileId, $token)
    {
        $paymentFile = PaymentBatch::find($fileId);

        $data = [
            'scheduleId' => $paymentFile->schedule_id,
        ];

        $response = Http::timeout(500)->accept('application/json')->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(env('RESIDENT_BASE_URL') . '/closeschedule', $data);

        $responseData = $response->json();
        if (isset($responseData) && isset($responseData["success"]) && $responseData["success"] === true) {
            return $responseData["data"];
        } else {
            \Log::info($responseData);
            return null;
        }
    }

    public function generateReference()
    {
        $range = range(0, 99);
        $pin   = $range;
        $set   = shuffle($pin);
        $code  = "";
        for ($i = 0; $i < 15; $i++) {
            $code = $code . "" . $pin[$i];
        }

        return time() . substr($code, 0, 8);
    }
}
