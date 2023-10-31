<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'customer_id',
        'payment_mode',
        'payment_status',
        'invoice_date',
        'created_by',
        'updated_by',
        'status',
        'is_deleted',
    ];
    function invoice_detail(){
        return $this->hasMany(InvoiceDetail::class)->where('status',0);
    }
    function user(){
        return $this->hasOne(user::class,'id','customer_id');
    }
    function customer(){
        return $this->hasOne(user::class,'id','customer_id');
    }
    function therapist(){
        return $this->hasOne(user::class,'id','therapist_id');
    }
    function appointment(){
        return $this->hasOne(Appointment::class,'id','appointment_id');
    }
    function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
