<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class OrderDetails extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'discount',
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function updateBy(){
        return $this->belongsTo(User::class,'update_by')->withDefault();
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id')->withDefault();
    }

}

