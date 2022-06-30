<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Product extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'name',
        'slug',
        'code',
        'point',
        'business_category',
        'category_id',
        'brand_id',
        'unit_id',
        'warranty_id',
        'sale_price',
        'wholesale_price',
        'discount_amount',
        'photo',
        'has_stock',
        'view_section',
        'excerpts',
        'details',
        'user_id',
        'update_by',
        'status'
    ];


    const NEW_ARRIVAL_SECTION = 'NEW_ARRIVAL_SECTION';
    const BEST_SELLER_SECTION = 'BEST_SECTION_SECTION';

    public function user(){
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id')->withDefault();
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id')->withDefault();
    }
    public function warranty(){
        return $this->belongsTo(Warranty::class,'warranty_id')->withDefault();
    }
     public function unit(){
        return $this->belongsTo(Unit::class,'unit_id')->withDefault();
    }



    public function updateBy(){
        return $this->belongsTo(User::class,'update_by');
    }

    public function productPhoto(){
        return $this->hasMany(Productphoto::class)->withDefault();
    }

}

