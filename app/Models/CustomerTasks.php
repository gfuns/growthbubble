<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTasks extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\TaskCategory', 'task_category');
    }

    public function creator()
    {
        if ($this->user_id == $this->creator) {
            return "Customer";
        } else {
            $user = User::find($this->creator);
            return $user->last_name . " " . $user->other_names;
        }
    }

    public function recurringDate()
    {
        $recDate = $this->recurring_date;
        if (str_ends_with($recDate, "1")) {
            return $recDate . "st";
        } else if (str_ends_with($recDate, "2")) {
            return $recDate . "nd";
        } else if (str_ends_with($recDate, "3")) {
            return $recDate . "rd";
        } else {
            return $recDate . "th";
        }
    }

    public function assignee()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to');
    }

    public function assignor()
    {
        return $this->belongsTo('App\Models\User', 'assigned_by');
    }
}
