<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCustomerReg extends Model
{
    use HasFactory;

    protected $table = 'customer_regist_v';
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'register_date',
        'is_member',
    ];
}
