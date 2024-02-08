<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCustomerTrans extends Model
{
    use HasFactory;

    protected $table = 'customer_trans_history_v';
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'treatment_date',
        'invoice_type',
    ];
}
