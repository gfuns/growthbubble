<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo('App\Models\Product', "product_id");
    }

    public function features()
    {
        return $this->hasMany('App\Models\PlanFeatures', "plan_id");
    }
}
