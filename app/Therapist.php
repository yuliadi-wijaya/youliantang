<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $table = 'therapists';

    protected $fillable = [
        'user_id',
		'ktp',
		'gender',
		'place_of_birth',
		'birth_date',
		'address',
		'rekening_number',
		'emergency_contact',
		'emergency_name',
        'slot_time',
		'status',
        'is_deleted',
    ];
}
