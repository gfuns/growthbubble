<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', "product_id");
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\SubscriptionPlan', "plan_id");
    }

    public function name()
    {
        $date = (new \DateTime($this->due_date))->format('M, Y');
        $name = $this->product->product . " (" . $this->plan->plan . " " . ucwords($this->plan->frequency) . ") " . $date;
        return $name;
    }

    public static function booted()
    {

        static::created(function ($invoice) {
            $invoice->invoice_number = self::genInvoiceNumber($invoice->id);
            $invoice->save();
        });
    }

/**
 * genInvoiceNumber
 *
 * @param mixed id
 *
 * @return void
 */
    public static function genInvoiceNumber($id)
    {
        if (strlen($id) == 1) {
            return "INV-00000" . $id;
        } else if (strlen($id) == 2) {
            return "INV-0000" . $id;
        } else if (strlen($id) == 3) {
            return "INV-000" . $id;
        } else if (strlen($id) == 4) {
            return "INV-00" . $id;
        } else if (strlen($id) == 5) {
            return "INV-0" . $id;
        } else if (strlen($id) == 6) {
            return "INV-" . $id;
        }

    }
}
