<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTherapistTotal extends Model
{
    use HasFactory;

    protected $table = 'therapist_total_v';
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'status',
    ];
}
