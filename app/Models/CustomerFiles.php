<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFiles extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'creator');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\User', 'shared_with');
    }

}
