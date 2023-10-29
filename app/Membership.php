<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'memberships';

    protected $fillable = [
        'name',
        'discount_type',
        'discount_value',
        'status',
        'total_active_period',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
}
