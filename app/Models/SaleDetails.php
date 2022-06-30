<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class SaleDetails extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',
    ];

    public function sale(){
        return $this->belongsTo(Sale::class,'sale_id')->withDefault();
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}

