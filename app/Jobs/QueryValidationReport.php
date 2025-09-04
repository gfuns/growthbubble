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

class QueryValidationReport implements ShouldQueue
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

        if (! empty($paymentFile)) {

            $token = $this->generateToken();

            if (! empty($token)) {
                $validationReport = $this->queryValidationReport($this->fileId, $token);
                if (! empty($validationReport)) {

                    // \Log::info($validationReport);

                    foreach ($validationReport['data']['records'] as $record) {
                        $ph = PaymentHistory::where('trace_id', $record['serialNo'])->first();
                        $ph->update(
                            [
                                'validation' => "completed",
                                'processing' => "in-progress",
                            ]
                        );
                    }

                    if ($validationReport['data']['hasMore'] === false) {
                        $paymentFile->validation = "completed";
                        $paymentFile->save();
                    }

                    $paymentFile->validation_last_index = $validationReport['data']['lastIndex'];
                    $paymentFile->save();

                    \Log::info("Successful Validation Status Captured Successfully");

                } else {

                    \Log::error("Querying Successful Validation Report Failed");

                }
            }
        }
    }

    public function queryValidationReport($fileId, $token)
    {
        $paymentFile = PaymentFiles::find($fileId);

        $data = [
            "RequestId" => $paymentFile->validation_request_id,
            'Limit'     => "1000",
            'LastIndex' => $paymentFile->validation_last_index,
        ];

        $response = Http::timeout(800)->accept('application/json')->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(env('RESIDENT_BASE_URL') . '/retrievevalidationstatus', $data);

        $responseData = $response->json();

        if (isset($responseData) && isset($responseData["success"]) && $responseData["success"] === true) {
            return $responseData;
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
}
