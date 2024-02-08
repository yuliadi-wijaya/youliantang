<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionNew extends Model
{
    protected $table = 'transaction_new';

    protected $fillable = [
        'customer_name',
        'room',
        'therapist_name',
        'product',
        'total_cost',
        'payment_method',
        'created_by',
        'updated_by',
        'is_deleted',
    ];
}
