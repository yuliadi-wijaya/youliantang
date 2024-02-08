<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTranSum extends Model
{
    use HasFactory;

    protected $table = 'trans_history_sum_v';
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'treatment_date',
        'therapist_name',
        'invoice_type',
    ];
}
