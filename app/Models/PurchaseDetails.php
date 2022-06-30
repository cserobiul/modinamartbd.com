<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class PurchaseDetails extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'purchase_id',
        'product_id',
        'color_id',
        'size_id',
        'unit_price',
        'quantity',
        'total_price',
        'serial',
        'warranty_id',
    ];

    public function purchase(){
        return $this->hasMany(Purchase::class,'purchase_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id')->withDefault();
    }

}

