<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Accounts extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'invoice_id',
        'payment_date',
        'amount',
        'customer_id',
        'supplier_id',
        'purpose',
        'payment_method_id',
        'transaction_id',
        'remarks',
        'user_id',
        'update_by',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function updateBy(){
        return $this->belongsTo(User::class,'update_by')->withDefault();
    }
    public function payment(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id')->withDefault();
    }

}

