<?php
namespace App\Http\Resources;

use App\Models\Employees;
use App\Models\PaymentBreakdown;
use App\Models\PaymentFiles;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Fetch file details
        $file = PaymentFiles::find($this->file_id);

        // Fetch employee details
        $employee = Employees::where("employee_number", $this->unique_id)->first();

        // Default values if classification is not 'payrol'
        $gross_pay        = $this->amount;
        $total_deductions = 0;
        $net_pay          = $this->amount;

        // If classification is 'payrol', fetch breakdown details
        if ($file && $file->classification === 'payrol') {
            $breakdown = PaymentBreakdown::where("employee_number", $this->unique_id)
                ->where("file_id", $this->file_id)
                ->first();

            if ($breakdown) {
                $gross_pay        = $breakdown->gross_pay;
                $total_deductions = $breakdown->total_deductions;
                $net_pay          = $breakdown->net_pay;
            }
        }

        return [
            'id'               => $this->id,
            'file_id'          => $this->file_id,
            'employee_number'  => $this->unique_id,
            'employee_id'      => $employee->id ?? null, // Get employee_id or return null if not found
            'amount'           => $this->amount,
            'classification'   => $file->classification ?? 'N/A',
            'gross_pay'        => $gross_pay,
            'total_deductions' => $total_deductions,
            'net_pay'          => $net_pay,
            'created_at'       => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
