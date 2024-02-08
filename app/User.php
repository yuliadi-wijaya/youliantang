<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Notifications\Notifiable;
use App\Events\AccountCreated;

class User extends EloquentUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone_number',
        'profile_photo',
        'created_by',
        'updated_by',
        'permissions',
        'status',
        'is_deleted',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */

    function therapist(){
        return $this->hasOne(Therapist::class);
    }

    function receptionist(){
        return $this->hasOne(Receptionist::class);
    }

    function customer(){
        return $this->hasOne(Customer::class);
    }

}
