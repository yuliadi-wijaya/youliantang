<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receptionist extends Model
{
    use HasFactory;
    protected $fillable = [
        'therapist_id',
        'user_id',
        'status',
        'is_deleted',
    ];

    function therapist()
    {
        return $this->hasOne(User::class, 'id', 'therapist_id');
    }
}
