<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $table = 'prescriptions';

    protected $fillable = [
        'customer_id',
        'symptoms',
        'diagnosis',
        'prescription_date',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
    function doctor(){
        return $this->hasOne(User::class,'id','created_by');
    }
    function customer(){
        return $this->hasOne(User::class,'id','customer_id');
    }
    function appointment(){
        return $this->hasOne(Appointment::class,'id','appointment_id');
    }
}
