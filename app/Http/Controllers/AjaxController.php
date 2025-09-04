<?php
namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\GradeLevels;
use App\Models\PayGroups;
use App\Models\PromotionalStep;
use App\Models\Units;

class AjaxController extends Controller
{
    public function getLevels($workgroup, $paygroup)
    {
        if ($paygroup == "All") {
            $levels = GradeLevels::where('work_group_id', $workgroup)->pluck('grade_level', 'id');
        } else {
            $levels = GradeLevels::where('paygroup_id', $paygroup)->pluck('grade_level', 'id');
        }

        return response()->json($levels);
    }

    public function getSteps($workgroup, $level)
    {
        if ($level == "All") {
            $steps = PromotionalStep::where('work_group_id', $workgroup)->pluck('step', 'id');
        } else {
            $steps = PromotionalStep::where('gradelevel_id', $level)->pluck('step', 'id');
        }

        return response()->json($steps);
    }

    public function getDepartments($workgroup, $branch)
    {
        if ($branch == "All") {
            $departments = Departments::where('workgroup_id', $workgroup)->pluck('department', 'id');
        } else {
            $departments = Departments::where('branch_id', $branch)->pluck('department', 'id');
        }

        return response()->json($departments);
    }

    public function getUnits($workgroup, $department)
    {
        if ($department == "All") {
            $units = Units::where('workgroup_id', $workgroup)->pluck('unit', 'id');
        } else {
            $units = Units::where('department_id', $department)->pluck('unit', 'id');
        }

        return response()->json($units);
    }

    public function getPaygroups($workgroup)
    {
        if ($workgroup == "All") {
            $paygroups = PayGroups::where('work_group_id', $workgroup)->pluck('paygroup', 'id');
        } else {
            $paygroups = PayGroups::where('work_group_id', $workgroup)->pluck('paygroup', 'id');
        }

        return response()->json($paygroups);
    }
}
