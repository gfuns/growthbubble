<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'other_names',
        'email',
        'organization',
        'contact_address',
        'phone_number',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function userRole()
    {
        return $this->belongsTo('App\Models\UserRole', "role_id");
    }

    public function subscription()
    {
        return $this->hasMany('App\Models\CustomerSubscription', "user_id");
    }

    public function selectedProduct()
    {
        $subscription = CustomerSubscription::orderBy("id", "desc")->where("user_id", $this->id)->first();
        if (isset($subscription)) {
            return $subscription->product->product;
        } else {
            return "NIL";
        }
    }

    public function selectedPlan()
    {
        $subscription = CustomerSubscription::orderBy("id", "desc")->where("user_id", $this->id)->first();
        if (isset($subscription)) {
            return $subscription->plan->plan . " " . ucwords($subscription->plan->frequency);
        } else {
            return "NIL";
        }
    }

    public function effectiveDate()
    {
        $subscription = CustomerSubscription::orderBy("id", "desc")->where("user_id", $this->id)->first();
        if (isset($subscription)) {
            return date_format(new DateTime($subscription->effective_date), "jS F, Y");
        } else {
            return "NIL";
        }
    }

    public function expiryDate()
    {
        $subscription = CustomerSubscription::orderBy("id", "desc")->where("user_id", $this->id)->first();
        if (isset($subscription)) {
            return date_format(new DateTime($subscription->expiry_date), "jS F, Y");
        } else {
            return "NIL";
        }
    }

    public function subStatus()
    {
        $subscription = CustomerSubscription::orderBy("id", "desc")->where("user_id", $this->id)->first();
        if (isset($subscription)) {
            return ucwords($subscription->status);
        } else {
            return "NIL";
        }
    }

}
