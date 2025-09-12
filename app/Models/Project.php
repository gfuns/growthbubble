<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
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
}
