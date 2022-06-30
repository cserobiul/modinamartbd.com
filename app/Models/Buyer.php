<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Buyer extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'buy_amount',
        'paid_payment',
        'current_due',
        'user_id',
        'update_by',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function updateBy(){
        return $this->belongsTo(User::class,'update_by');
    }
}

