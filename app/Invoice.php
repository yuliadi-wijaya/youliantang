<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'customer_name',
        'therapist_name',
        'room',
        'payment_mode',
        'payment_status',
        'treatment_date',
        'treatment_time_from',
        'treatment_time_to',
        'note',
        'status',
        'is_deleted',
        'customer_id',
        'old_data',
        'is_member',
        'use_member',
        'member_plan',
        'voucher_code',
        'total_price',
        'discount',
        'tax_rate',
        'tax_amount',
        'grand_total',
        'invoice_code',
        'invoice_type',
    ];
    function invoice_detail(){
        return $this->hasMany(InvoiceDetail::class)->where('is_deleted',0);
    }
    function user(){
        return $this->hasOne(user::class,'id','customer_id');
    }
    function customer(){
        return $this->hasOne(user::class,'id','customer_id');
    }
    function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
