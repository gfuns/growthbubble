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

class MonitorCoralPayWebhook implements ShouldQueue
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
        // \Log::info($paymentFile);

        if (isset($paymentFile)) {
            //Get total amount
            $pp = PaymentHistory::where("workgroup_id", $paymentFile->workgroup_id)
                ->where("file_id", $paymentFile->id)
                ->whereNull('status')->count();

            if ($pp < 1) {
                $paymentFile->processing       = "completed";
                $paymentFile->status           = "completed";
                $paymentFile->schedule_control = "feedback received";
                $paymentFile->save();
            }

            if ($paymentFile->classification == "payrol") {
                $payrol         = PayrolSummary::find($paymentFile->payrol_id);
                $payrol->status = "completed";
                $payrol->save();
            }
        }
    }
}
