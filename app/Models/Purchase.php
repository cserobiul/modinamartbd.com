<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Purchase extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'purchase_no',
        'invoice_no',
        'purchase_date',
        'purchase_amount',
        'discount',
        'pay_amount',
        'due_amount',
        'supplier_id',
        'payment_method_id',
        'transaction_id',
        'user_id',
        'updateBy',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }
    public function updateBy(){
        return $this->belongsTo(User::class,'update_by');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id')->withDefault();
    }
    public function purchaseDetails(){
        return $this->belongsTo(PurchaseDetails::class)->withDefault();
    }
    public function payment(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id')->withDefault();
    }



}

