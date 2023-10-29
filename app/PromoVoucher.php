<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoVoucher extends Model
{
    protected $table = 'promo_vouchers';

    protected $fillable = [
        'name',
        'promo_id',
        'voucher_code',
    ];
}
