<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Size extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'size_name',
        'photo',
        'user_id',
        'update_by',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function updateBy(){
        return $this->belongsTo(User::class,'update_by');
    }
}

