<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Settings extends Model
{
    use HasFactory;
    use HasRoles;

    protected $fillable = [
        'app_name',
        'logo', 'favicon',
        'email', 'phone',
        'address',
        'social_facebook',
        'social_instagram',
        'social_youtube',
        'footer',
        'status',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETE = 'delete';
    const STATUS_BAN = 'ban';

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCEL = 'cancel';
    const STATUS_SHIPPING = 'shipping';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PAID = 'paid';
    const STATUS_UNPAID = 'unpaid';


    const ACCOUNTS_PURCHASE_PAYMENT = 'PURCHASE_PAYMENT';
    const ACCOUNTS_PURCHASE_DUE = 'PURCHASE_DUE';
    const ACCOUNTS_BUY_PAYMENT = 'BUY_PAYMENT';
    const ACCOUNTS_BUY_DUE = 'BUY_DUE';

    const SALE_PAYMENT = 'SALE_PAYMENT';
    const SALE_DUE_PAYMENT = 'SALE_DUE_PAYMENT';
    const SALE_DUE = 'SALE_DUE';

    const REWARD_BONUS = 'REWARD_BONUS';
    const REWARD_BUY_PRODUCT = 'REWARD_BUY_PRODUCT';
    const REWARD_WITHDRAW = 'REWARD_WITHDRAW';
    const PRODUCT_RETURN_LOST_POINT = 'PRODUCT_RETURN_LOST_POINT';


    const RETURN_WITH_PRODUCT = 'RETURN_WITH_PRODUCT';
    const RETURN_WITH_MONEY = 'RETURN_WITH_MONEY';


    //Custom Function

    public static function slugWithUnicode($data)
    {
        if (strlen($data) != strlen(utf8_decode($data))) {
            return preg_replace('/\s+/u', '-', trim($data));
        } else {
            return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data)));
        }
    }

    public static function unicodeName($data)
    {
        if (strlen($data) != strlen(utf8_decode($data))) {
            return $data;
        } else {
            return ucwords($data);
        }
    }

    public static function invoiceGenerator()
    {
        $lastTransaction = Order::orderBy('created_at', 'DESC')->get();
        if (count($lastTransaction) > 0) {
            $lastTransaction = Order::orderBy('created_at', 'DESC')->first();
            if ($lastTransaction) {
                $lastINV = explode("-", $lastTransaction->invoice_id);
                return 'INV-' . $lastINV[1] + 1;
            } else {
                return 'INV-1000001';
            }
        } else {
            return 'INV-1000001';
        }

    }

    public static function accountInvoiceGenerator()
    {
        $lastTransaction = Accounts::orderBy('created_at', 'DESC')->get();
        if (count($lastTransaction) > 0) {
            $lastTransaction = Accounts::orderBy('created_at', 'DESC')->first();
            if ($lastTransaction) {
                $lastINV = explode("-", $lastTransaction->invoice_id);
                return 'INV-' . $lastINV[1] + 1;
            } else {
                return 'INV-1000001';
            }
        } else {
            return 'INV-1000001';
        }

    }

    public static function purchaseInvoiceGenerator()
    {
        $lastTransaction = Purchase::orderBy('created_at', 'DESC')->get();
        if (count($lastTransaction) > 0) {
            $lastTransaction = Purchase::orderBy('created_at', 'DESC')->first();
            if ($lastTransaction->invoice_no) {
                $lastINV = explode("-", $lastTransaction->invoice_no);
                return 'INV-' . $lastINV[1] + 1;
            } else {
                return 'INV-1000001';
            }
        } else {
            return 'INV-1000001';
        }

    }

    public static function saleInvoiceGenerator()
    {
        $lastTransaction = Sale::orderBy('created_at', 'DESC')->get();
        if (count($lastTransaction) > 0) {
            $lastTransaction = Sale::orderBy('created_at', 'DESC')->first();
            if ($lastTransaction->invoice_no) {
                $lastINV = explode("-", $lastTransaction->invoice_no);
                return 'INV-S-' . $lastINV[2] + 1;
            } else {
                return 'INV-S-1000001';
            }
        } else {
            return 'INV-S-1000001';
        }

    }

    public static function oidGenerator()
    {
        $lastOrder = Order::orderBy('created_at', 'DESC')->get();
        if (count($lastOrder) > 0) {
            $lastOrder = Order::orderBy('created_at', 'DESC')->first();
            if ($lastOrder) {
                $lastINV = explode("-", $lastOrder->oid);
                return 'OID-' . $lastINV[1] + 1;
            } else {
                return 'OID-1000001';
            }
        } else {
            return 'OID-1000001';
        }

    }


    public static function productStock($productId)
    {
        $hasStock = Stock::where('product_id', $productId)->first();

        if ($hasStock) {
            $stock = Stock::where('product_id', $productId)->first();
            return $stock->stock;
        } else {
            return 0;
        }

    }


    public static function supplierTotalPurchaseAmount($suupplierId)
    {
        return Purchase::where('supplier_id', $suupplierId)->sum('purchase_amount');
    }

    public static function supplierTotalPaidAmount($suupplierId)
    {
        return Purchase::where('supplier_id', $suupplierId)->sum('pay_amount');
    }

    public static function supplierTotalDueAmount($suupplierId)
    {
        return Purchase::where('supplier_id', $suupplierId)->sum('due_amount');
    }


}
