<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSettings extends Model
{
    use HasFactory;

    protected $table = "invoice_setting";

    protected $fillable = [
        "invoice_type"
    ];
}
