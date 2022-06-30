<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Sale extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'sale_date',
        'invoice_no',
        'buyer_id',
        'total_price',
        'total_point',
        'total_discount',
        'special_discount',
        'paid',
        'due',
        'payment_method_id',
        'user_id',
        'update_by',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function buyer(){
        return $this->belongsTo(Buyer::class,'buyer_id')->withDefault();
    }

    public function updateBy(){
        return $this->belongsTo(User::class,'update_by');
    }
}

