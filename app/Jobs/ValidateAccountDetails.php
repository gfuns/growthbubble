<?php
namespace App\Jobs;

use App\Models\PaymentFiles;
use App\Models\PaymentHistory;
use App\Models\ResidentToken;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ValidateAccountDetails implements ShouldQueue
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
        $reference   = $this->generateReference();
        if (! empty($paymentFile)) {

            $token = $this->generateToken();

            if (! empty($token)) {

                $pushForValidation = $this->pushForValidation($this->fileId, $token, $reference);

                if (! empty($pushForValidation)) {

                    \Log::info($pushForValidation);

                    $paymentFile->validation_request_id = $pushForValidation["requestId"];
                    $paymentFile->save();

                } else {

                    \Log::error("Pushing Payment File For Validation Failed");

                }
            }
        }
    }

    public function pushForValidation($fileId, $token, $reference)
    {
        $paymentFile = PaymentFiles::find($fileId);

        $beneficiaries = PaymentHistory::where("file_id", $paymentFile->id)->where("validation", "pending")
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
            "referenceId" => $reference,
            "paymentMode" => "1",
            'data'        => $beneficiaries,
        ];

        $response = Http::timeout(800)->accept('application/json')->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(env('RESIDENT_BASE_URL') . '/uploadvalidationjson', $data);

        $responseData = $response->json();

        if (isset($responseData) && isset($responseData["success"]) && $responseData["success"] === true) {
            return $responseData["data"];
        } else {
            \Log::info($responseData);
            return null;
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
