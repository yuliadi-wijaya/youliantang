<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTherapistTransDetail extends Model
{
    use HasFactory;

    protected $table = 'therapist_trans_history_detail_v';
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'treatment_date',
        'invoice_type',
    ];
}
