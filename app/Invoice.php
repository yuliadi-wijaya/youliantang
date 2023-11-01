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
        'treatment_date',
        'treatment_time_from',
        'treatment_time_to',
        'payment_mode',
        'payment_status',
        'note',
        'status',
        'is_deleted',
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
