<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'stripe/*',
        'checkout-page',
        'accounts/customer-return-product/store',
        'accounts/buyer-return-product/store',
        'accounts/supplier-return-product',
        'customer-profile-update',
        'product-purchase-cart',
        'purchase',
        'purchase/create',
        'sale/create',
    ];
}
