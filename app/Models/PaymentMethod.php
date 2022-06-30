<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class PaymentMethod extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'payment_name',
        'details',
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

