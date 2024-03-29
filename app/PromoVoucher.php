<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoVoucher extends Model
{
    protected $table = 'promo_vouchers';

    protected $fillable = [
        'promo_id',
        'voucher_code',
        'is_used',
    ];

    function promo(){
        return $this->belongsTo(Promo::class)->where('is_deleted',0);
    }
}
