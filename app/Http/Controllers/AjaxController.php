<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SubscriptionPlan;

class AjaxController extends Controller
{
    public function getCustomerProjects($customerId)
    {

        $projects = Project::where('user_id', $customerId)->pluck('project_title', 'id');

        return response()->json($projects);
    }

    public function getProductPlans($productId)
    {

        $plans = SubscriptionPlan::where('product_id', $productId)
            ->get()
            ->mapWithKeys(function ($plan) {
                return [
                    $plan->id => $plan->plan . ' ' . ucwords($plan->frequency) . ' - £' . number_format($plan->pricing),
                ];
            });

        return response()->json($plans);
    }

}
