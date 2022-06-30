<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Producttemp;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Settings;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class PurchaseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('purchase.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Purchase";
        $data['purchases'] = Purchase::orderBy('created_at', 'DESC')->simplePaginate(100);
        return view('backend.purchase.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('purchase.create')) {
            abort(403, 'Unauthorized Action');
        }
        $tempData['tempproducts'] = Producttemp::where('user_id', Auth::user()->id)->get();
        $tempData['totalPurchaseAmount'] = 0;
        $lastPurchase = Purchase::all()->last();

        $tempData['invoice_no'] = Settings::purchaseInvoiceGenerator();


        return view('backend.purchase.create', $tempData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($formDatas);
        // dd($request->purchaseCartData);
        //Check authentication
        if (!Auth::user()->can('purchase.create')) {
            abort(403, 'Unauthorized Action');
        }

        $validator = Validator::make($request->all(), [
            'invoice_no' => ['required', 'string', 'min:6', 'max:20'],
            'purchase_date' => ['required', 'string'],
            'purchase_amount' => ['required', 'string', 'min:1', 'max:99999999'],
            'pay_amount' => ['required', 'string', 'min:0', 'max:purchase_amount'],
            'due_amount' => ['nullable', 'string', 'min:0', 'max:99999999'],
            'supplier_name' => ['required', 'string', 'min:1', 'max:255'],
            'payment_method' => ['required', 'string', 'min:1', 'max:255'],
        ], [
            'pay_amount.required' => 'Paid Amount Required'
        ]);

        if ($validator->passes()) {
        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            //Purchase Table
            $lastPurchase = Purchase::orderBy('created_at', 'DESC')->first();
            if ($lastPurchase) {
                $lastPurchaseNo = explode("-", $lastPurchase->purchase_no);
                $data['purchase_no'] = 'PR-' . $lastPurchaseNo[1] + 1;
            } else {
                $data['purchase_no'] = 'PR-1000001';
            }

            $data['invoice_no'] = $request->invoice_no;
            $data['purchase_date'] = $request->purchase_date;
            $data['supplier_id'] = $request->supplier_name;
            $data['payment_method_id'] = $request->payment_method;
            $data['transaction_id'] = $request->transaction_id;
            $data['purchase_amount'] = $request->purchase_amount;
            $data['pay_amount'] = $request->pay_amount;
            $data['due_amount'] = $request->due_amount;

            //who create this !?
            $data['user_id'] = Auth::user()->id;

            //Purchase Details Table
            $purchase = Purchase::create($data);

            //Purchase Details table, Stock table
            foreach ($request->purchaseCartData as $product) {
                $dataP['purchase_id'] = $purchase->id;
                $dataP['product_id'] = $product['productId'];
                $dataP['quantity'] = $product['quantity'];
                $dataP['unit_price'] = $product['price'];
                $dataP['total_price'] = $product['totalPrice'];
//                $dataP['warranty_id'] = $product['warranty'];
                $dataP['warranty_id'] = 1;
                $dataP['serial'] = $product['serial'];

                PurchaseDetails::create($dataP);

                $chkStock = Stock::where('product_id', $dataP['product_id'])
                    ->first();

                if ($chkStock) {
                    $oldStock = $chkStock->stock;
                    $oldPurchase = $chkStock->purchase;
                    $dataS['stock'] = $oldStock + $dataP['quantity'];
                    $dataS['purchase'] = $oldPurchase + $dataP['quantity'];

                    DB::table('stocks')
                        ->where('id', $chkStock->id)
                        ->update($dataS);
                } else {
                    $dataS['product_id'] = $dataP['product_id'];
                    $dataS['stock'] = $dataP['quantity'];
                    $dataS['purchase'] = $dataP['quantity'];
                    Stock::create($dataS);
                } //Stock Table end
            }// end foreach loop

            //Accounts table
            $dataAcc['invoice_id'] = $request->invoice_no;
            $dataAcc['payment_date'] = $request->purchase_date;
            $dataAcc['supplier_id'] = $request->supplier_name;
            $dataAcc['remarks'] = $request->remarks;
            $dataAcc['user_id'] = Auth::user()->id;

            $supplierInfo = Supplier::where('id', $request->supplier_name)->first();

            $oldPurchasePayment = $supplierInfo->purchase_amount;               // add old and new purchase amount
            $dataSupPA['purchase_amount'] = $oldPurchasePayment + $request->purchase_amount;    // update total purchase amount
            DB::table('suppliers')->where('id', $request->supplier_name)->update($dataSupPA);

            if ($request->pay_amount > 0) {  // if get any amount of payment than add account table
                $dataAcc['amount'] = $request->pay_amount;
                $dataAcc['purpose'] = Settings::ACCOUNTS_PURCHASE_PAYMENT;
                $dataAcc['payment_method_id'] = $request->payment_method;
                $dataAcc['transaction_id'] = $request->transaction_id;
                Accounts::create($dataAcc);

                //Supplier table
                $oldTotalPayment = $supplierInfo->get_payment;
                $dataSupp['get_payment'] = $oldTotalPayment + $request->pay_amount;
                DB::table('suppliers')->where('id', $request->supplier_name)->update($dataSupp);
            }
            if ($request->due_amount > 0) {   // if has any amount of payment due than add account table
                $dataAcc['amount'] = $request->due_amount;
                $dataAcc['purpose'] = Settings::ACCOUNTS_PURCHASE_DUE;
                $dataAcc['payment_method_id'] = null;
                $dataAcc['transaction_id'] = null;
                Accounts::create($dataAcc);

                //Supplier table
                $oldTotalDue = $supplierInfo->current_due;
                $dataSupp['current_due'] = $oldTotalDue + $request->due_amount;
                DB::table('suppliers')->where('id', $request->supplier_name)->update($dataSupp);

            }

            DB::commit();

            return response()->json(['success' => 'Successfully Create a new Purchase']);

        } catch (\Exception $exception) {
            DB::rollBack();
           // return $exception->getMessage();
            return response()->json(['error' => 'Something went wrong, try again.']);
        }

//        return redirect()->back()->with('success','Successfully Create a new Purchase');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Purchase $purchase
     * @return  \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //Check authentication
        if (!Auth::user()->can('purchase.show')) {
            abort(403, 'Unauthorized Action');
        }
        $data['purchase'] = Purchase::findOrFail($purchase->id);
        $data['purchaseDetails'] = PurchaseDetails::with('product')->where('purchase_id', $purchase->id)->get();


        return view('backend.purchase.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Purchase $purchase
     * @return  \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //Check authentication
        if (!Auth::user()->can('purchase.update')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Purchase";
        $data['purchase'] = Purchase::findOrFail($purchase->id);
        return view('backend.purchase.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purchase $purchase
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('purchase.update')) {
            abort(403, 'Unauthorized Action');
        }
        $checkPurchase = Purchase::findOrFail($id);

        $request->validate([
            'purchase' => ['required', 'string', 'min:3', 'max:255', 'unique:purchases,id,' . $request->id],
            'purchase_no' => ['nullable', 'string', 'min:3', 'max:255'],
            'invoice_no' => ['nullable', 'string', 'min:3', 'max:255'],
            'purchase_date' => ['nullable', 'string', 'min:3', 'max:255'],
            'purchase_amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'discount' => ['nullable', 'string', 'min:3', 'max:255'],
            'pay_amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'due_amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'serial' => ['nullable', 'string', 'min:3', 'max:255'],
            'supplier_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_method_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'user_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'updateBy' => ['nullable', 'string', 'min:3', 'max:255'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ], [
            'purchase_no.required' => 'Please input purchase_no',
            'invoice_no.required' => 'Please input invoice_no',
            'purchase_date.required' => 'Please input purchase_date',
            'purchase_amount.required' => 'Please input purchase_amount',
            'discount.required' => 'Please input discount',
            'pay_amount.required' => 'Please input pay_amount',
            'due_amount.required' => 'Please input due_amount',
            'serial.required' => 'Please input serial',
            'supplier_id.required' => 'Please input supplier_id',
            'payment_method_id.required' => 'Please input payment_method_id',
            'user_id.required' => 'Please input user_id',
            'updateBy.required' => 'Please input updateBy',
        ]);
        $data['purchase_no'] = $request->purchase_no;
        $data['invoice_no'] = $request->invoice_no;
        $data['purchase_date'] = $request->purchase_date;
        $data['purchase_amount'] = $request->purchase_amount;
        $data['discount'] = $request->discount;
        $data['pay_amount'] = $request->pay_amount;
        $data['due_amount'] = $request->due_amount;
        $data['serial'] = $request->serial;
        $data['supplier_id'] = $request->supplier_id;
        $data['payment_method_id'] = $request->payment_method_id;
        $data['user_id'] = $request->user_id;
        $data['updateBy'] = $request->updateBy;
        $data['status'] = $request->status;

        //purchase photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/purchase';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;

            if (file_exists($checkPurchase->photo)) {
                unlink($checkPurchase->photo);
            }
        }

        DB::table('purchases')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success', 'Successfully Updated Purchase');

    }

    public function producttempdel($id)
    {

        $hasProduct = Producttemp::findOrFail($id);

        if (!is_null($hasProduct)) {
            $hasProduct->delete();
        }
        return redirect()->back();

    }

    public function producttemp(Request $request)
    {

        dd($request->all());
        $request->validate([
            'product_name' => ['required', 'string', 'min:1', 'max:255'],
            'color_name' => ['nullable', 'string', 'min:1', 'max:255'],
            'size_name' => ['nullable', 'string', 'min:1', 'max:255'],
            'warranty' => ['nullable', 'string', 'min:1', 'max:255'],
            'quantity' => ['required', 'string', 'min:1', 'max:99999999'],
            'unit_price' => ['required', 'string', 'min:1', 'max:99999999'],
            'serial' => ['nullable', 'string', 'min:3', 'max:255'],
        ], [
            'product_name.required' => 'Select a product',
            'unit_price.required' => 'Input Unit Price',
        ]);

        $dataP['product_id'] = $request->product_name;
        $dataP['color_id'] = $request->color_name;
        $dataP['size_id'] = $request->size_name;
        $dataP['quantity'] = $request->quantity;
        $dataP['unit_price'] = $request->unit_price;
        $dataP['total_price'] = $request->unit_price * $request->quantity;
//        $dataP['warranty_id'] = $request->warranty;
        $dataP['warranty_id'] = 1;
        $dataP['serial'] = $request->serial;

        //who create this !?
        $dataP['user_id'] = Auth::user()->id;

        Producttemp::create($dataP);
        return redirect()->back();

    }

    public function stock()
    {
        $data['stocks'] = Stock::select('product_id')->distinct()->simplePaginate(100);
        return view('backend.stock.index', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Purchase $purchase
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //Check authentication
        if (!Auth::user()->can('purchase.delete')) {
            abort(403, 'Unauthorized Action');
        }
        $checkPurchase = Purchase::findOrFail($purchase->id);

        if (!is_null($purchase)) {
            $purchase->delete();
        }

        return redirect()->back()->with('success', 'Purchase Deleted Successfully');

    }
}

