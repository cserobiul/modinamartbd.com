<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ProductReturn;
use App\Models\ProductReturnDetails;
use App\Models\Producttemp;
use App\Models\Reward;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SaleTransaction;
use App\Models\Settings;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;
use function PHPUnit\Framework\isNull;

class ProductReturnController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */


    public function customerProductReturn()
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['pageTitle'] = "Online Customer Product Return";
        return view('backend.return.customer_return_step1', $data);

    }

    public function customerProductReturnProcess(Request $request)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }
        $orderId = $request->order_id;
        $data['pageTitle'] = "Online Customer Product Return";
        $hasOrder = Order::where('id', $orderId)->orWhere('oid', $orderId)->get();


        if (count($hasOrder) > 0) {
            $data['order'] = Order::where('id', $orderId)->orWhere('oid', $orderId)->first();
            $data['customer'] = Customer::where('id', $data['order']->customer_id)->first();
            $data['orderDetails'] = OrderDetails::where('order_id', $data['order']->id)->get();
            return view('backend.return.customer_return_step2', $data);
        } else {
//            return view('backend.return.return')->with('warning','No Order Found, Please input valid order id');
            return back()->with('warning', 'No Order Found, Please input valid order id');
        }

    }

    public function customerProductReturnProcessStore(Request $request)
    {

        $checkOrder = Order::where('id', $request->order_id)->get();
        $hasOrder = Order::where('id', $request->order_id)->first();
        $customerData = Customer::where('id', $hasOrder->customer_id)->first();

        if (count($checkOrder) > 0) {
            // dd($request->returnCartData );
            DB::beginTransaction();
            try {
                $totalAmount = 0;
                $invoiceId = Settings::invoiceGenerator();
                $data['user_id'] = Auth::user()->id;

                $dataReturn['order_id'] = $hasOrder->id;
                $dataReturn['invoice_id'] = $invoiceId;
                $dataReturn['return_date'] = $request->return_date;
                $dataReturn['purpose'] = $request->return_type;
                $dataReturn['customer_id'] = $customerData->id;
                $dataReturn['user_id'] = $data['user_id'];

                $productReturn = ProductReturn::create($dataReturn);

                foreach ($request->returnCartData as $product) {
                    $dataReturnDetails['product_return_id'] = $productReturn->id;
                    $dataReturnDetails['product_id'] = $product['productId'];
                    $dataReturnDetails['quantity'] = $product['quantity'];
                    $dataReturnDetails['unit_price'] = $product['price'];
                    $dataReturnDetails['amount'] = $product['quantity'] * $product['price'];

                    ProductReturnDetails::create($dataReturnDetails);

                    $totalAmount += $product['totalPrice'];

                    if ($request->return_type == Settings::RETURN_WITH_MONEY) {
                        $chkStock = Stock::where('product_id', $product['productId'])->first();
                        if ($chkStock) {
                            $dataS['stock'] = $chkStock->stock + $product['quantity'];  // old stock + return quantity
                            $dataS['sales_return'] = $chkStock->sales_return + $product['quantity']; // old sales return + return quantity
//                            $dataS['sales'] = $chkStock->sales - $product['quantity']; // old sales - return quantity

                            DB::table('stocks')
                                ->where('product_id', $product['productId'])
                                ->update($dataS);
                        }
                    }

                }

                if ($request->return_type == Settings::RETURN_WITH_MONEY) {
                    $dataAcc['invoice_id'] = $invoiceId;
                    $dataAcc['payment_date'] = $request->return_date;
                    $dataAcc['amount'] = $totalAmount;
                    $dataAcc['customer_id'] = $customerData->id;
                    $dataAcc['purpose'] = $request->return_type;
                    $dataAcc['payment_method_id'] = $request->payment_method;
                    $dataAcc['transaction_id'] = $request->transaction_id;
                    $dataAcc['user_id'] = $data['user_id'];
                    Accounts::create($dataAcc);

                    //Customer Table

                    $dataCustomer['buy_amount'] = $customerData->buy_amount - $totalAmount; // ok
                    $currentDue = $customerData->current_due;
                    if ($currentDue > $totalAmount) {    // if due bigger than return amount
                        $dataCustomer['current_due'] = $currentDue - $totalAmount; // ok
                        $dataReturnUpdate['remark'] = 'Due amount bigger than return amount, so current due reduced ' . $totalAmount . ' Taka and customer named ' . $customerData->customer_name . ' s buy amount reduced ' . $totalAmount . ' Taka';

                    } elseif ($currentDue < $totalAmount) {    // if total amount bigger than due amount
                        $restAmount = $totalAmount - $currentDue;
                        $dataCustomer['paid_payment'] = $customerData->paid_payment - $restAmount;
                        $dataCustomer['current_due'] = 0;
                        $dataReturnUpdate['remark'] = 'Total amount bigger than due amount, so due = 0, and customer named ' . $customerData->customer_name . ' get ' . $restAmount . ' Taka return';
                    }
                    DB::table('customers')->where('id', $customerData->id)->update($dataCustomer); // update customer buy amount,paid and current due

                    $dataReturnUpdate['amount'] = $totalAmount;
                    DB::table('product_returns')->where('id', $productReturn->id)->update($dataReturnUpdate);

                }

                DB::commit();
                return json_encode(['response' => true]);
            } catch (\Exception $exception) {
//                echo '<pre>';
//                return $exception->getMessage();
//                return back()->with('warning', 'Something error, please contact support.');
                DB::rollBack();
                return json_encode(['response' => false]);
            }
        } else {
            return json_encode(['response' => false]);
        }
    }


    public function buyerProductReturn()
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['pageTitle'] = "Customer Product Return";
        return view('backend.return.buyer_return_step1', $data);

    }

    public function buyerProductReturnProcess(Request $request)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }
        $invoice_no = $request->invoice_no;
        $data['pageTitle'] = "Customer Product Return";
        $hasSale = Sale::where('id', $invoice_no)->orWhere('invoice_no', $invoice_no)->get();


        if (count($hasSale) > 0) {
            $data['sale'] = Sale::where('id', $invoice_no)->orWhere('invoice_no', $invoice_no)->first();
            $data['buyer'] = Buyer::where('id', $data['sale']->buyer_id)->first();
            $data['saleDetails'] = SaleDetails::where('sale_id', $data['sale']->id)->get();
            return view('backend.return.buyer_return_step2', $data);
        } else {
            return back()->with('warning', 'No Sale Found, Please input valid Invoice No');
        }

    }

    public function buyerProductReturnProcessStore(Request $request)
    {

       // dd($request->all());
        $checkSale = Sale::where('id', $request->sale_id)->get();
        $hasSale = Sale::where('id', $request->sale_id)->first();
        $buyerData = Buyer::where('id', $hasSale->buyer_id)->first();

        if (count($checkSale) > 0) {
            // dd($request->returnCartData );
            DB::beginTransaction();
            try {
                $totalAmount = 0;
                $invoiceId = Settings::saleInvoiceGenerator();
                $data['user_id'] = Auth::user()->id;

                $dataBuyerReturn['sale_id'] = $hasSale->id;
                $dataBuyerReturn['buyer_id'] = $buyerData->id;
                $dataBuyerReturn['invoice_id'] = $invoiceId;
                $dataBuyerReturn['return_date'] = $request->return_date;
                $dataBuyerReturn['purpose'] = $request->return_type;
                $dataBuyerReturn['user_id'] = $data['user_id'];

                $productBuyerReturn = ProductReturn::create($dataBuyerReturn);

                foreach ($request->buyerReturnCartData as $product) {
                    $dataBuyerReturnDetails['product_return_id'] = $productBuyerReturn->id;
                    $dataBuyerReturnDetails['product_id'] = $product['productId'];
                    $dataBuyerReturnDetails['quantity'] = $product['quantity'];
                    $dataBuyerReturnDetails['unit_price'] = $product['price'];
                    $dataBuyerReturnDetails['amount'] = $product['quantity'] * $product['price'];

                    ProductReturnDetails::create($dataBuyerReturnDetails);

                    $saleData = Reward::where('sale_id',$request->sale_id)->where('product_id',$product['productId'])->first();   // get sale data for getting product points

                    //Reward Point less(-) from current points
                    if ($saleData){
                        $dataReward['sale_id'] = $request->sale_id;
                        $dataReward['product_id'] = $product['productId'];
                        $dataReward['buyer_id'] = $buyerData->id;
                        $dataReward['point'] = $saleData->point;    // reduce point for this product
                        $dataReward['type'] = 1;
                        $dataReward['purpose'] = Settings::PRODUCT_RETURN_LOST_POINT;
                        $dataReward['user_id'] = Auth::user()->id; //who create this !?
                        Reward::create($dataReward);
                    }

                    $totalAmount += $product['totalPrice'];

                    if ($request->return_type == Settings::RETURN_WITH_MONEY) {
                        $chkStock = Stock::where('product_id', $product['productId'])->first();
                        if ($chkStock) {
                            $dataS['stock'] = $chkStock->stock + $product['quantity'];  // old stock + return quantity
                            $dataS['sales_return'] = $chkStock->sales_return + $product['quantity']; // old sales return + return quantity
//                            $dataS['sales'] = $chkStock->sales - $product['quantity']; // old sales - return quantity

                            DB::table('stocks')
                                ->where('product_id', $product['productId'])
                                ->update($dataS);
                        }
                    }

                }

                if ($request->return_type == Settings::RETURN_WITH_MONEY) {
                    $dataAcc['invoice_no'] = $invoiceId;
                    $dataAcc['payment_date'] = $request->return_date;
                    $dataAcc['amount'] = $totalAmount;
                    $dataAcc['buyer_id'] = $buyerData->id;
                    $dataAcc['purpose'] = $request->return_type;
                    $dataAcc['payment_method_id'] = $request->payment_method;
                    $dataAcc['transaction_id'] = $request->transaction_id;
                    $dataAcc['user_id'] = $data['user_id'];
                    SaleTransaction::create($dataAcc);

                    //Buyer Table

                    $dataBuyer['buy_amount'] = $buyerData->buy_amount - $totalAmount; // ok
                    $currentDue = $buyerData->current_due;
                    if ($currentDue > $totalAmount) {    // if due bigger than return amount
                        $dataBuyer['current_due'] = $currentDue - $totalAmount; // ok
                        $dataReturnUpdate['remark'] = 'Due amount bigger than return amount, so current due reduced ' . $totalAmount . ' Taka and customer named ' . $buyerData->name . ' s buy amount reduced ' . $totalAmount . ' Taka';

                    } elseif ($currentDue < $totalAmount) {    // if total amount bigger than due amount
                        $restAmount = $totalAmount - $currentDue;
                        $dataBuyer['paid_payment'] = $buyerData->paid_payment - $restAmount;
                        $dataBuyer['current_due'] = 0;
                        $dataReturnUpdate['remark'] = 'Total amount bigger than due amount, so due = 0, and customer named ' . $buyerData->name . ' get ' . $restAmount . ' Taka return';
                    }
                    DB::table('buyers')->where('id', $buyerData->id)->update($dataBuyer); // update buyer buy amount,paid and current due

                    $dataReturnUpdate['amount'] = $totalAmount;
                    DB::table('product_returns')->where('id', $productBuyerReturn->id)->update($dataReturnUpdate);

                }

                DB::commit();
                return json_encode(['response' => true]);
            } catch (\Exception $exception) {
//                echo '<pre>';
//                return $exception->getMessage();
//                return back()->with('warning', 'Something error, please contact support.');
                DB::rollBack();
                return json_encode(['response' => false]);
            }
        } else {
            return json_encode(['response' => false]);
        }
    }


    public function supplierProductReturn()
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['pageTitle'] = "Supplier Product Return";
        $data['invoice_id'] = Settings::invoiceGenerator();
        return view('backend.return.supplier_return', $data);

    }

    public function supplierProductReturnProcess(Request $request)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }
        return redirect()->route('dashboard');
        dd($request->all());
    }


    public function productPriceCheck($product_id)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $product = Product::where('id', $product_id)->first();
        if ($product) {
            $data['product_price'] = $product->sale_price;
            $data['product_name'] = Settings::unicodeName($product->name);
            return $data;
        } else {
            return 0;
        }
    }


    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('productreturn.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "ProductReturn";
        $data['productreturns'] = ProductReturn::where('status', 'active')->orderBy('created_at', 'DESC')->get();
        return view('backend.productreturn.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('productreturn.create')) {
            abort(403, 'Unauthorized Action');
        }
        return view('backend.productreturn.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('productreturn.create')) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'order_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'purchase_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'product_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'quantity' => ['nullable', 'string', 'min:3', 'max:255'],
            'amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'purpose' => ['nullable', 'string', 'min:3', 'max:255'],
            'user_id' => ['nullable', 'string', 'min:3', 'max:255'],
        ], [
            'order_id.required' => 'Please input order_id',
            'purchase_id.required' => 'Please input purchase_id',
            'product_id.required' => 'Please input product_id',
            'quantity.required' => 'Please input quantity',
            'amount.required' => 'Please input amount',
            'purpose.required' => 'Please input purpose',
            'user_id.required' => 'Please input user_id',
        ]);
        $data['order_id'] = $request->order_id;
        $data['purchase_id'] = $request->purchase_id;
        $data['product_id'] = $request->product_id;
        $data['quantity'] = $request->quantity;
        $data['amount'] = $request->amount;
        $data['purpose'] = $request->purpose;
        $data['user_id'] = $request->user_id;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //dd($data);

        //productreturn photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/productreturn';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;
        }
        $productreturn = ProductReturn::create($data);
        return redirect()->back()->with('success', 'Successfully Create a new ProductReturn');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProductReturn $productreturn
     * @return  \Illuminate\Http\Response
     */
    public function show(ProductReturn $productreturn, $id)
    {
        //Check authentication
        if (!Auth::user()->can('productreturn.show')) {
            abort(403, 'Unauthorized Action');
        }
        $data['productreturn'] = ProductReturn::findOrFail($id);
        return view('backend.productreturn.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProductReturn $productreturn
     * @return  \Illuminate\Http\Response
     */
    public function edit(ProductReturn $productreturn)
    {
        //Check authentication
        if (!Auth::user()->can('productreturn.update')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "ProductReturn";
        $data['productreturn'] = ProductReturn::findOrFail($id);
        return view('backend.productreturn.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductReturn $productreturn
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('productreturn.update')) {
            abort(403, 'Unauthorized Action');
        }
        $checkProductReturn = ProductReturn::findOrFail($id);

        $request->validate([
            'productreturn' => ['required', 'string', 'min:3', 'max:255', 'unique:productreturns,id,' . $request->id],
            'order_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'purchase_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'product_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'quantity' => ['nullable', 'string', 'min:3', 'max:255'],
            'amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'purpose' => ['nullable', 'string', 'min:3', 'max:255'],
            'user_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ], [
            'order_id.required' => 'Please input order_id',
            'purchase_id.required' => 'Please input purchase_id',
            'product_id.required' => 'Please input product_id',
            'quantity.required' => 'Please input quantity',
            'amount.required' => 'Please input amount',
            'purpose.required' => 'Please input purpose',
            'user_id.required' => 'Please input user_id',
        ]);
        $data['order_id'] = $request->order_id;
        $data['purchase_id'] = $request->purchase_id;
        $data['product_id'] = $request->product_id;
        $data['quantity'] = $request->quantity;
        $data['amount'] = $request->amount;
        $data['purpose'] = $request->purpose;
        $data['user_id'] = $request->user_id;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //productreturn photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/productreturn';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;

            if (file_exists($checkProductReturn->photo)) {
                unlink($checkProductReturn->photo);
            }
        }

        DB::table('productreturns')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success', 'Successfully Updated ProductReturn');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProductReturn $productreturn
     * @return  \Illuminate\Http\Response
     */
    public function destroy(ProductReturn $productreturn)
    {
        //Check authentication
        if (!Auth::user()->can('productreturn.delete')) {
            abort(403, 'Unauthorized Action');
        }
        $checkProductReturn = ProductReturn::findOrFail($productreturn->id);

        if (!is_null($productreturn)) {
            $productreturn->delete();
        }

        return redirect()->back()->with('success', 'ProductReturn Deleted Successfully');

    }
}
