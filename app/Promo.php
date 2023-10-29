<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';

    protected $fillable = [
        'name',
        'description',
        'discount_type',
        'discount_value',
        'discount_max_value',
        'active_period_start',
        'active_period_end',
        'is_reuse_voucher',
        'status',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
}
