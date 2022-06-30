<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Order extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'oid',
        'customer_id',
        'invoice_id',
        'total_price',
        'total_discount',
        'special_discount',
        'payment_method_id',
        'order_note',
        'shipping_address',
        'shipping_type',
        'shipping_amount',
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
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id')->withDefault();
    }
    public function payment(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id')->withDefault();
    }


}

