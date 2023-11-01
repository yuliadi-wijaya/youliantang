<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistAvailableSlot extends Model
{
    use HasFactory;
    protected $fillable = [
        'therapist_id',
        'therapist_available_id',
        'from',
        'to',
        'status',
        'is_deleted',
    ];
    function appointment(){
        return $this->hasMany(Appointment::class,'available_slot','id');
    }

}
