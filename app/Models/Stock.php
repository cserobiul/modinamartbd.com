<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Stock extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'purchase',
        'purchase_return',
        'sales',
        'sales_return',
        'stock',
    ];

    public function product(){
        return $this->belongsTo(Product::class)->withDefault();
    }
    public function color(){
        return $this->belongsTo(Color::class)->withDefault();
    }
    public function size(){
        return $this->belongsTo(Size::class)->withDefault();
    }




}

