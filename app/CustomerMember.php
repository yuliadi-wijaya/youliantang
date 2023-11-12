<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMember extends Model
{
    protected $table = 'customer_members';

    protected $fillable = [
        'customer_id',
        'membership_id',
        'expired_date',
        'status',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
}
