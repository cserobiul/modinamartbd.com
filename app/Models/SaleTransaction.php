<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class SaleTransaction extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    protected $fillable = [
        'sale_id',
        'invoice_no',
        'payment_date',
        'buyer_id',
        'amount',
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
        return $this->belongsTo(User::class,'update_by');
    }

    public function payment(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id')->withDefault();
    }
}

