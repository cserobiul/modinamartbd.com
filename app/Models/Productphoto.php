<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Productphoto extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'product_id',
        'photo',
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
     public function product(){
        return $this->belongsTo(Product::class)->withDefault();
    }


}

