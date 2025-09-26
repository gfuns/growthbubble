<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionInfo extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo('App\Models\Product', "product_id");
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\SubscriptionPlan', "plan_id");
    }
}
