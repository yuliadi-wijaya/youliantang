<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receptionist extends Model
{
    protected $table = 'receptionists';

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
		'status',
        'is_deleted',
    ];
}
