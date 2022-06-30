<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Producttemp extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'warranty_id',
        'quantity',
        'unit_price',
        'total_price',
        'serial',
        'user_id',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function product(){
        return $this->belongsTo(Product::class)->withDefault();
    }
    public function color(){
        return $this->belongsTo(Color::class)->withDefault();
    }
    public function size(){
        return $this->belongsTo(Size::class)->withDefault();
    }
    public function warranty(){
        return $this->belongsTo(Warranty::class)->withDefault();
    }



}

