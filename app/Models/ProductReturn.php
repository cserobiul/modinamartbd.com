<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class ProductReturn extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'order_id',
        'sale_id',
        'purchase_id',
        'customer_id',
        'buyer_id',
        'supplier_id',
        'invoice_id',
        'return_date',
        'amount',
        'purpose',
        'remark',
        'user_id',
        'update_by',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function updateBy()
    {
        return $this->belongsTo(User::class, 'update_by')->withDefault();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id')->withDefault();
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id')->withDefault();
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withDefault();
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id')->withDefault();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault();
    }


}

