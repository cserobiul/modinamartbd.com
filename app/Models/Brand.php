<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Brand extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'brand_name',
        'slug',
        'photo',
        'user_id',
        'update_by',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function updateBy(){
        return $this->belongsTo(User::class,'update_by');
    }

}

