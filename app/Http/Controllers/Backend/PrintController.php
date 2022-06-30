<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SaleTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrintController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function invoicePrint($order_id){
        //Check authentication
        if (!Auth::user()->can('print.all')){
            abort(403,'Unauthorized Action');
        }
        //Check has order
        $data['order'] = Order::findOrfail($order_id);
        $data['orderDetails'] = OrderDetails::where('order_id',$order_id)->get();

        $data['customer'] = Customer::where('id',$data['order']->customer_id)->first();

        $pdf = PDF::loadView('backend.print.invoice_print',$data)->setPaper('a4', 'portrait');
        return $pdf->stream('INVOICE_'.$data['order']->invoice_id.'.pdf');
//        return $pdf->stream('invoice.pdf');
//        $pdf = \Barryvdh\DomPDF\Facade::loadView('backend.profile.certificate',$data)->setPaper('a4', 'landscape');
//        return $pdf->stream('certificate_'.$data['profile']->member_id.'_batch_'.$data['profile']->batch_name.'.pdf');


    }

    public function saleInvoicePrint($sale_id){
        //Check authentication
        if (!Auth::user()->can('print.all')){
            abort(403,'Unauthorized Action');
        }
        //Check has order
        $data['sale'] = Sale::findOrfail($sale_id);
        $data['saleDetails'] = SaleDetails::where('sale_id',$sale_id)->get();

        $data['buyer'] = Buyer::where('id',$data['sale']->buyer_id)->first();

        $pdf = PDF::loadView('backend.print.sale_invoice_print',$data)->setPaper('a4', 'portrait');
        return $pdf->stream('SALE_INVOICE_'.$data['sale']->invoice_no.'.pdf');
    }

    public function buyerDueCollectionInvoicePrint($sale_transaction_id){
        //Check authentication
        if (!Auth::user()->can('print.all')){
            abort(403,'Unauthorized Action');
        }
        //Check has order
        $data['saleTransactionId'] = SaleTransaction::findOrfail($sale_transaction_id);

        $data['buyer'] = Buyer::where('id',$data['sale']->buyer_id)->first();

        $pdf = PDF::loadView('backend.print.buyer_due_collection_invoice_print',$data)->setPaper('a4', 'portrait');
        return $pdf->stream('BUYER_DUE_COLLECTION_INVOICE_'.$data['saleTransactionId']->invoice_no.'.pdf');
    }




}
