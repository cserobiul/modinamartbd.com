<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Reward extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'sale_id',
        'buyer_id',
        'order_id',
        'customer_id',
        'product_id',
        'point',
        'purpose',
        'type',
        'user_id',
        'update_by',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function updateBy(){
        return $this->belongsTo(User::class,'update_by')->withDefault();
    }
    public function sale(){
        return $this->belongsTo(Sale::class,'sale_id')->withDefault();
    }
    public function buyer(){
        return $this->belongsTo(Buyer::class,'buyer_id')->withDefault();
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id')->withDefault();
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id')->withDefault();
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id')->withDefault();
    }


    public static function buyerPointsToMoney($buyerId)
    {
        $pointEarn = Reward::where('buyer_id',$buyerId)
                ->where('type',0)
                ->sum('point');
        $pointWithdraw = Reward::where('buyer_id',$buyerId)
                ->where('type',1)
                ->sum('point');
        $point = $pointEarn - $pointWithdraw;

        //1 tk = 5 points
        return $money = $point / 5;
    }

    public static function buyerRemainingPoints($buyerId)
    {
        $pointEarn = Reward::where('buyer_id',$buyerId)
                ->where('type',0)
                ->sum('point');
        $pointWithdraw = Reward::where('buyer_id',$buyerId)
                ->where('type',1)
                ->sum('point');

        return $point = $pointEarn - $pointWithdraw;

    }
    public static function buyerEarnPoints($buyerId)
    {
        Return Reward::where('buyer_id',$buyerId)
                ->where('type',0)
                ->sum('point');
    }
    public static function buyerWithdrawPoints($buyerId)
    {
        Return Reward::where('buyer_id',$buyerId)
                ->where('type',1)
                ->sum('point');
    }

    public static function customerPointsToMoney($customerId)
    {
        $pointEarn = Reward::where('customer_id',$customerId)
            ->where('type',0)
            ->sum('point');
        $pointWithdraw = Reward::where('buyer_id',$customerId)
            ->where('type',1)
            ->sum('point');

        return $point = $pointEarn - $pointWithdraw;

    }
    public static function customerRemainingPoints($customerId)
    {
        $pointEarn = Reward::where('customer_id',$customerId)
                ->where('type',0)
                ->sum('point');
        $pointWithdraw = Reward::where('customer_id',$customerId)
                ->where('type',1)
                ->sum('point');

        return $point = $pointEarn - $pointWithdraw;

    }
    public static function customerEarnPoints($customerId)
    {
        Return Reward::where('customer_id',$customerId)
                ->where('type',0)
                ->sum('point');
    }
    public static function customerWithdrawPoints($customerId)
    {
        Return Reward::where('customer_id',$customerId)
                ->where('type',1)
                ->sum('point');
    }

    public static function supplierTotalDueAmount($suupplierId){
        return Purchase::where('supplier_id',$suupplierId)->sum('due_amount');
    }

}

