<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Reward;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SaleTransaction;
use App\Models\Settings;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Validator;

class SaleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('sale.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Sale";
        $data['sales'] = Sale::with(['user','buyer'])->where('status', 'active')->orderBy('created_at', 'DESC')->get();
        return view('backend.sale.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('sale.create')) {
            abort(403, 'Unauthorized Action');
        }
        $data['totalSaleAmount'] = 0;
        $data['invoice_no'] = Settings::saleInvoiceGenerator();

        return view('backend.sale.create', $data);
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
        if (!Auth::user()->can('sale.create')) {
            abort(403, 'Unauthorized Action');
        }

        $validator = Validator::make($request->all(), [
            'sale_date' => ['required', 'string'],
            'invoice_no' => ['required', 'string', 'min:6', 'max:20'],
            'sale_amount' => ['required', 'string', 'min:1', 'max:99999999'],
            'special_discount' => ['nullable', 'string', 'min:0', 'max:sale_amount'],
            'pay_amount' => ['required', 'string', 'min:0', 'max:sale_amount'],
            'due_amount' => ['nullable', 'string', 'min:0', 'max:sale_amount'],
            'buyer_name' => ['required', 'string', 'min:1', 'max:255'],
            'payment_method' => ['required', 'string', 'min:1', 'max:255'],
        ], [
            'buyer_name.required' => 'Customer Required',
            'pay_amount.required' => 'Paid Amount Required',
            'payment_method.required' => 'Payment Method Required',
        ]);

        if ($validator->passes()) {
        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }


        DB::beginTransaction();
        try {
            if ($request->buyer_name == 'newBuyer') {
                //Data process for buyer table
                $dataBuyer['name'] = $request->name;
                $dataBuyer['phone'] = $request->phone;
                $dataBuyer['email'] = $request->email;
                $dataBuyer['address'] = $request->address;
                $dataBuyer['user_id'] = Auth::user()->id; //who create this !?
                //dd($dataBuyer);
                $buyer = Buyer::create($dataBuyer);

                $dataNewBuyerReward['buyer_id'] = $buyer->id;
                $dataNewBuyerReward['point'] = 500;
                $dataNewBuyerReward['type'] = 0;
                $dataNewBuyerReward['purpose'] = Settings::REWARD_BONUS;
                $dataNewBuyerReward['user_id'] = $dataBuyer['user_id'];

                Reward::create($dataNewBuyerReward);
            } else {
                 $buyer = Buyer::where('id', $request->buyer_name)->first();
            }

            //Sale Table
            $data['invoice_no'] = $request->invoice_no;
            $data['sale_date'] = $request->sale_date;
            $data['buyer_id'] = $buyer->id;
            $data['payment_method_id'] = $request->payment_method;
            $data['transaction_id'] = $request->transaction_id;
            $data['total_point'] = $request->total_point;
            $data['total_price'] = $request->sale_amount - $request->special_discount;
            $data['special_discount'] = $request->special_discount;
            $data['total_discount'] = $request->discount;
            $data['paid'] = $request->pay_amount;
            $data['due'] = $request->due_amount;
            $data['user_id'] = Auth::user()->id; //who create this !?

            //Create Sale
            $sale = Sale::create($data);

            //Sale Details Table, Stock table
            foreach ($request->saleCartData as $product) {
                $dataSaleDetails['sale_id'] = $sale->id;
                $dataSaleDetails['product_id'] = $product['productId'];
                $dataSaleDetails['quantity'] = $product['quantity'];
                $dataSaleDetails['price'] = $product['price'];
//                $dataSaleDetails['discount'] = $product['discount'];
                SaleDetails::create($dataSaleDetails);

                $chkStock = Stock::where('product_id', $dataSaleDetails['product_id'])->first();

                if ($chkStock) {
                    $oldStock = $chkStock->stock;
                    $oldSales = $chkStock->sales;
                    $dataS['stock'] = $oldStock - $dataSaleDetails['quantity'];
                    $dataS['sales'] = $oldSales + $dataSaleDetails['quantity'];

                    DB::table('stocks')
                        ->where('id', $chkStock->id)
                        ->update($dataS);
                } else {
                    return response()->json(['error' => 'Low Stock.- ' . $product['productName']]);
                } //Stock Table end
            }// end foreach loop

            //Reward Points Table
            foreach ($request->saleCartData as $product) {
                $dataReward['sale_id'] = $sale->id;
                $dataReward['product_id'] = $product['productId'];
                $dataReward['buyer_id'] = $buyer->id;
                $dataReward['point'] = $product['point'] * $product['quantity'];
                $dataReward['purpose'] = Settings::REWARD_BUY_PRODUCT;
                $dataReward['user_id'] = Auth::user()->id; //who create this !?
                Reward::create($dataReward);
            }// end foreach loop


            //Sale Transaction table
            $dataAcc['invoice_no'] = $request->invoice_no;
            $dataAcc['payment_date'] = $request->sale_date;
            $dataAcc['buyer_id'] = $buyer->id;
            $dataAcc['remarks'] = $request->remarks;
            $dataAcc['user_id'] = Auth::user()->id;

            if ($request->pay_amount > 0) {
                $dataAcc['sale_id'] = $sale->id;
                $dataAcc['amount'] = $request->pay_amount;
                $dataAcc['payment_method_id'] = $request->payment_method;
                $dataAcc['transaction_id'] = $request->transaction_id;
                $dataAcc['purpose'] = Settings::SALE_PAYMENT;
                SaleTransaction::create($dataAcc);
            }

            $checkDue = $request->sale_amount - $request->pay_amount;

            if ($checkDue > 0) {
                $dataAcc['amount'] = $checkDue;
                $dataAcc['purpose'] = Settings::SALE_DUE;
                SaleTransaction::create($dataAcc);
            }

            //Buyer Table
            $dataBuyer['buy_amount'] = $buyer->buy_amount + $request->sale_amount;
            $dataBuyer['paid_payment'] = $buyer->paid_payment + $request->pay_amount;
            $dataBuyer['current_due'] = $buyer->current_due + $checkDue;
            DB::table('buyers')->where('id', $buyer->id)->update($dataBuyer);

            DB::commit();
            return response()->json(['success' => 'Successfully Sale Created']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
            return response()->json(['error' => 'Something went wrong, when place a sale. try again.']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Sale $sale
     * @return  \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //Check authentication
        if (!Auth::user()->can('sale.show')) {
            abort(403, 'Unauthorized Action');
        }
        $data['sale'] = Sale::findOrFail($sale->id);
        $data['saleDetails'] = SaleDetails::where('sale_id',$sale->id)->get();
        return view('backend.sale.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Sale $sale
     * @return  \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //Check authentication
        if (!Auth::user()->can('sale.update')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Sale";
        $data['sale'] = Sale::findOrFail($id);
        return view('backend.sale.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sale $sale
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('sale.update')) {
            abort(403, 'Unauthorized Action');
        }
        $checkSale = Sale::findOrFail($id);

        $request->validate([
            'sale' => ['required', 'string', 'min:3', 'max:255', 'unique:sales,id,' . $request->id],
            'buyer_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'total_price' => ['nullable', 'string', 'min:3', 'max:255'],
            'total_discount' => ['nullable', 'string', 'min:3', 'max:255'],
            'special_discount' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_method_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ], [
            'buyer_id.required' => 'Please input buyer_id',
            'total_price.required' => 'Please input total_price',
            'total_discount.required' => 'Please input total_discount',
            'special_discount.required' => 'Please input special_discount',
            'payment_method_id.required' => 'Please input payment_method_id',
        ]);
        $data['buyer_id'] = $request->buyer_id;
        $data['total_price'] = $request->total_price;
        $data['total_discount'] = $request->total_discount;
        $data['special_discount'] = $request->special_discount;
        $data['payment_method_id'] = $request->payment_method_id;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //sale photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/sale';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;

            if (file_exists($checkSale->photo)) {
                unlink($checkSale->photo);
            }
        }

        DB::table('sales')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success', 'Successfully Updated Sale');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Sale $sale
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //Check authentication
        if (!Auth::user()->can('sale.delete')) {
            abort(403, 'Unauthorized Action');
        }
        $checkSale = Sale::findOrFail($sale->id);

        if (!is_null($sale)) {
            $sale->delete();
        }

        return redirect()->back()->with('success', 'Sale Deleted Successfully');

    }
}

