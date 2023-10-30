<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistAvailableTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'therapist_id',
        'from',
        'to',
        'status',
        'is_deleted',
    ];
}
