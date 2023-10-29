<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'duration',
        'price',
        'commission_fee',
        'status',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
}
