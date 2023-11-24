<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'customer_id',
        'customer_name',
        'phone_number',
        'invoice_id',
        'rating',
        'comment',
        'created_at',
        'updated_at',
    ];
}
