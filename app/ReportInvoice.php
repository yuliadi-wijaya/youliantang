<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportInvoice extends Model
{
    use HasFactory;

    protected $table = 'report_invoices';
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'invoice_type',
        'invoice_code',
        'invoice_date',
    ];
}
