<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Order;
use App\Models\ProductReturn;
use App\Models\ProductReturnDetails;
use App\Models\Purchase;
use App\Models\Reward;
use App\Models\Sale;
use App\Models\SaleTransaction;
use App\Models\Settings;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function supplierDue()
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['suppliers'] = Supplier::orderBy('name', 'ASC')->simplePaginate(100);
        return view('backend.report.supplier_due', $data);
    }

    public function supplierDueDetails($supplierId)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['supplierDetails'] = Supplier::where('id', $supplierId)->first();

        $data['accounts'] = Accounts::where('supplier_id', $supplierId)
            ->where('purpose', Settings::ACCOUNTS_PURCHASE_PAYMENT)
            ->orderBy('payment_date', 'DESC')->get();

        $data['purchases'] = Purchase::where('supplier_id', $supplierId)
            ->orderBy('purchase_date', 'DESC')
            ->simplePaginate(100);
        return view('backend.report.supplier_due_details', $data);
    }

    public function buyerList()
    {
        //Check authentication
        if (!Auth::user()->can(['report.all','buyer.all'])){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Customer";
        $data['customers'] = Buyer::orderBy('created_at','DESC')->paginate(100);
        return view('backend.report.buyer_list',$data);

    }

    public function buyerPoint ()
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['buyers'] = Buyer::orderBy('id', 'DESC')->paginate(100);

        return view('backend.report.buyer_point', $data);
    }

    public function buyerPointDetails($buyerId)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['buyerDetails'] = Buyer::where('id', $buyerId)->first();

        $data['points'] = Reward::where('buyer_id', $buyerId)
                ->orderBy('created_at', 'DESC')
                ->get();

        //dd($data);
        return view('backend.report.buyer_point_details', $data);
    }



    public function buyerDue()
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['buyers'] = Buyer::orderBy('name', 'ASC')->paginate(100);
        return view('backend.report.buyer_due', $data);
    }

    public function buyerDueDetails($buyerId)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['buyerDetails'] = Buyer::where('id', $buyerId)->first();

        $data['accounts'] = SaleTransaction::with(['payment', 'user'])->where('buyer_id', $buyerId)
//            ->where('purpose', Settings::SALE_PAYMENT)
//            ->orWhere('purpose', Settings::SALE_DUE_PAYMENT)
            ->orderBy('payment_date', 'DESC')->get();

        $data['sales'] = Sale::where('buyer_id', $buyerId)
            ->orderBy('created_at', 'DESC')
            ->paginate(100);

        return view('backend.report.buyer_due_details', $data);
    }


    // Buyer Return List
    public function buyerReturnList()
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['productsReturn'] = ProductReturn::where('order_id', null)->orderBy('created_at', 'DESC')->paginate(100);
        return view('backend.report.buyer_product_return', $data);
    }

    //Single Buyer Return Details
    public function buyerReturnDetails($buyerId)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['buyerDetails'] = Buyer::where('id', $buyerId)->first();
        $data['productsReturn'] = ProductReturn::where('buyer_id', $buyerId)->orderBy('created_at', 'DESC')->paginate(100);
        return view('backend.report.buyer_wise_product_return', $data);
    }

    //Buyer Return details for any return product
    public function buyerProductReturnDetails($return_id)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['productsReturn'] = ProductReturnDetails::where('product_return_id', $return_id)->orderBy('created_at', 'DESC')->paginate(100);
        return view('backend.report.buyer_product_return_details', $data);
    }



    public function customerList()
    {
        //Check authentication
        if (!Auth::user()->can(['report.all','customer.all'])){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Online Customer";
        $data['customers'] = Customer::orderBy('created_at','DESC')->paginate(100);
        return view('backend.report.customer_list',$data);

    }


    public function customerPoint ()
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['customers'] = Customer::orderBy('id', 'DESC')->paginate(100);

        return view('backend.report.customer_point', $data);
    }

    public function customerPointDetails($customerId)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['customerDetails'] = Customer::where('id', $customerId)->first();

        $data['points'] = Reward::where('customer_id', $customerId)
            ->orderBy('created_at', 'DESC')
            ->get();

        //dd($data);
        return view('backend.report.customer_point_details', $data);
    }




    public function customerDue()
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['customers'] = Customer::orderBy('customer_name', 'ASC')->simplePaginate(100);
        return view('backend.report.customer_due', $data);
    }

    public function customerDueDetails($customerId)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['customerDetails'] = Customer::where('id', $customerId)->first();

        $data['accounts'] = Accounts::where('customer_id', $customerId)
            ->where('purpose', Settings::ACCOUNTS_BUY_PAYMENT)
            ->orderBy('payment_date', 'DESC')->get();

        $data['orders'] = Order::where('customer_id', $customerId)
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(100);
        return view('backend.report.customer_due_details', $data);
    }



    // Customer Return List
    public function customerReturnList()
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['productsReturn'] = ProductReturn::where('sale_id', null)->orderBy('created_at', 'DESC')->paginate(100);
        return view('backend.report.customer_product_return', $data);
    }

    //Single Customer Return Details
    public function customerReturnDetails($customerId)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['customerDetails'] = Customer::where('id', $customerId)->first();
        $data['productsReturn'] = ProductReturn::where('customer_id', $customerId)->orderBy('created_at', 'DESC')->paginate(100);
        return view('backend.report.customer_wise_product_return', $data);
    }

    //Customer Return details for any return product
    public function customerProductReturnDetails($return_id)
    {
        //Check authentication
        if (!Auth::user()->can('report.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['productsReturn'] = ProductReturnDetails::where('product_return_id', $return_id)->orderBy('created_at', 'DESC')->paginate(100);
        return view('backend.report.customer_product_return_details', $data);
    }

    public function supplierReturnList()
    {
        return back();
    }


}
