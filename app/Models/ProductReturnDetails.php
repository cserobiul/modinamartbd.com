<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class ProductReturnDetails extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'product_return_id',
        'product_id',
        'quantity',
        'unit_price',
        'amount',
        'status'
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
     public function productReturn(){
        return $this->belongsTo(ProductReturn::class,'product_return_id')->withDefault();
    }

}
