<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'address',
        'status',
        'is_deleted',
    ];

    function appointment(){
        return $this->hasMany(Appointment::class,'appointment_for','id');
    }
    function user(){
        return $this->hasOne(user::class,'appointment_with','id')->where('status',0);
    }
}
