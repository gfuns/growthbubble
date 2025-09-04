<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    public function feature()
    {
        return $this->belongsTo('App\Models\PlatformFeature', "feature_id");
    }
}
