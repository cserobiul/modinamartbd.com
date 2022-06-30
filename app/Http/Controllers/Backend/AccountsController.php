<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Settings;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    //  generally  bill collection
    public function billCollection(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $hasCustomerWithOrder = Order::where('customer_id', $request->bill_for)
            ->where('id', $request->order_id)
            ->first();

        $data['pageTitle'] = 'Bill Collection';
        $data['customerView'] = 'multiple';
        $data['invoice_id'] = Settings::accountInvoiceGenerator();

        return view('backend.accounts.bill_collection', $data);
    }

    public function billCollectionProcess(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }
        //who create this !?
        $data['user_id'] = Auth::user()->id;

        $customerData = Customer::where('id', $request->customer_name)->first();

        if ($customerData) {
            $data['invoice_id'] = $request->invoice_no;
            $data['payment_date'] = $request->payment_date;
            $data['customer_id'] = $request->customer_name;

            DB::beginTransaction();
            try {
                if ($request->amount > 0) {
                    $data['amount'] = $request->amount;
                    $data['purpose'] = Settings::ACCOUNTS_BUY_PAYMENT;
                    $data['payment_method_id'] = $request->payment_method;
                    Accounts::create($data);
                }

                $checkDue = $customerData->current_due - $request->amount;

                if ($checkDue > 0) {
                    $data['amount'] = $checkDue;
                    $data['purpose'] = Settings::ACCOUNTS_BUY_DUE;
                    Accounts::create($data);
                }

                //Customer Table
                $dataCustomer['paid_payment'] = $customerData->paid_payment + $request->amount;
                $dataCustomer['current_due'] = $customerData->current_due - $request->amount;
                DB::table('customers')->where('id', $request->customer_name)->update($dataCustomer);

                DB::commit();

            } catch (\Exception $exception) {
//                echo '<pre>';
//                return $exception->getMessage();
//                return back()->with('warning', 'Something error, please contact support.');
                DB::rollBack();
            }

        } else {
            return redirect()->route('billCollection')->with('warning', 'Customer data does not match...');
        }

        return redirect()->route('billCollection')->with('success', 'Successfully Bill Collect for ' . Settings::unicodeName($customerData->customer_name));
    }

    //    bill collection from shipping
    public function billCollectionFromShipping(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['order'] = Order::where('customer_id', $request->bill_for)
            ->where('id', $request->order_id)
            ->where('status', Settings::STATUS_SHIPPING)
            ->first();
        if ($data['order']) {    // if does match customer id and order id
            $data['customer'] = Customer::where('id', $request->bill_for)->first();
            $data['customerView'] = 'single';

            $data['pageTitle'] = 'Bill Collection from Shipping';
            $data['invoice_id'] = $data['order']->invoice_id;

            return view('backend.accounts.bill_collection', $data);
        } else {
            return redirect()->route('shippingOrder');
        }
    }

    public function billCollectionProcessFromShipping(Request $request)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['order'] = Order::where('customer_id', $request->bill_for)
            ->where('id', $request->order_id)
            ->where('status', Settings::STATUS_SHIPPING)
            ->first();

        if ($data['order']) {    // if does match customer id and order id
            $request->validate([
                'customer_name' => ['required', 'min:1', 'max:255'],
                'amount' => ['required', 'min:0', 'max:9999999999'],
                'payment_date' => ['required'],
                'invoice_no' => ['required', 'min:1', 'max:255'],
                'payment_method' => ['required', 'min:1', 'max:255'],
            ]);
            //who create this !?
            $data['user_id'] = Auth::user()->id;

            DB::beginTransaction();
            try {
                $data['customer'] = Customer::where('id', $request->bill_for)->first();

                $data['invoice_id'] = $data['order']->invoice_id;
                $data['payment_date'] = $request->payment_date;
                $data['customer_id'] = $data['customer']->id;

                if ($request->amount > 0) {
                    $data['amount'] = $request->amount;
                    $data['purpose'] = Settings::ACCOUNTS_BUY_PAYMENT;
                    $data['payment_method_id'] = $request->payment_method;
                    Accounts::create($data);
                }

                $checkDue = $data['order']->total_price - $request->amount;

                if ($checkDue > 0) {
                    $data['amount'] = $checkDue;
                    $data['purpose'] = Settings::ACCOUNTS_BUY_DUE;
                    Accounts::create($data);
                }

                //Customer Table
                $dataCustomer['buy_amount'] = $data['customer']->buy_amount + $data['order']->total_price;
                $dataCustomer['paid_payment'] = $data['customer']->paid_payment + $request->amount;
                $dataCustomer['current_due'] = $data['customer']->current_due + $checkDue;
                DB::table('customers')->where('id', $request->bill_for)->update($dataCustomer);

                //Order Table
                $dataOrder['status'] = Settings::STATUS_DELIVERED;
                DB::table('orders')->where('id', $request->order_id)->update($dataOrder);

                DB::commit();

                return redirect()->route('shippingOrder')->with('Success', 'Successfully Order delivered for.' . ucwords($data['customer']->customer_name));
            } catch (\Exception $exception) {
                DB::rollBack();
//                echo '<pre>';
//                return $exception->getMessage();
                return back()->with('warning', 'Something error, please contact support.');
            }

        } else {
            return redirect()->route('shippingOrder')->with('warning', 'Wrong order, try again...');
        }
    }


    public function billPaid()
    {
        //Check authentication
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['pageTitle'] = 'Paid Due';
        $data['invoice_id'] = Settings::accountInvoiceGenerator();

        return view('backend.accounts.bill_paid', $data);
    }

    public function billPaidProcess(Request $request)
    {

        //dd($request->all());
        //Check authentication
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'supplier_name' => ['required', 'min:1', 'max:255'],
            'amount' => ['required', 'min:1', 'max:99999999'],
            'payment_date' => ['required'],
            'invoice_no' => ['required', 'string', 'min:10', 'max:50'],
            'payment_method' => ['required', 'min:1', 'max:255'],
        ], [
            'supplier_name.required' => 'Please Select Supplier Name',
        ]);

        DB::beginTransaction();
        try {

            $data['invoice_id'] = $request->invoice_no;
            $data['payment_date'] = $request->payment_date;
            $data['amount'] = $request->amount;
            $data['supplier_id'] = $request->supplier_name;
            $data['payment_method_id'] = $request->payment_method;
            $data['purpose'] = 'PURCHASE_PAYMENT';

            //who create this !?
            $data['user_id'] = Auth::user()->id;

            Accounts::create($data);

            //Supplier table
            $supplierInfo = Supplier::where('id', $request->supplier_name)->first();

            $oldTotalPayment = $supplierInfo->get_payment;
            $dataSupp['get_payment'] = $oldTotalPayment + $request->amount;

            $oldTotalDue = $supplierInfo->current_due;
            $dataSupp['current_due'] = $oldTotalDue - $request->amount;

            DB::table('suppliers')->where('id', $request->supplier_name)->update($dataSupp);

            DB::commit();

            return back()->with('success', 'Successfully Paid Due to ' . $supplierInfo->name);

        } catch (\Exception $exception) {
            DB::rollBack();
//             echo '<pre>';
//             return $exception->getMessage();
             return back()->with('warning', 'Something error, please contact support.' );
        }


    }


    public function customerDueCheck($customer_id)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['customer'] = Customer::where('id', $customer_id)->first();
        if ($data['customer']) {
            return ($data['customer']->current_due == !null ? $data['customer']->current_due : 0);
        } else {
            return 0;
        }
    }

    public function supplierDueCheck($supplier_id)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['supplier'] = Supplier::where('id', $supplier_id)->first();
        if ($data['supplier']) {
            return ($data['supplier']->current_due == !null ? $data['supplier']->current_due : 0);
        } else {
            return 0;
        }
    }


    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('accounts.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Accounts";
        $data['accountss'] = Accounts::where('status', 'active')->orderBy('created_at', 'DESC')->get();
        return view('backend.accounts.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }
        return view('backend.accounts.create');
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
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'invoice_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_date' => ['nullable', 'string', 'min:3', 'max:255'],
            'amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'customer_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'supplier_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'purpose' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_method_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'remarks' => ['nullable', 'string', 'min:3', 'max:255'],
        ], [
            'invoice_id.required' => 'Please input invoice_id',
            'payment_date.required' => 'Please input payment_date',
            'amount.required' => 'Please input amount',
            'customer_id.required' => 'Please input customer_id',
            'supplier_id.required' => 'Please input supplier_id',
            'purpose.required' => 'Please input purpose',
            'payment_method_id.required' => 'Please input payment_method_id',
            'remarks.required' => 'Please input remarks',
        ]);
        $data['invoice_id'] = $request->invoice_id;
        $data['payment_date'] = $request->payment_date;
        $data['amount'] = $request->amount;
        $data['customer_id'] = $request->customer_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['purpose'] = $request->purpose;
        $data['payment_method_id'] = $request->payment_method_id;
        $data['remarks'] = $request->remarks;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //dd($data);

        //accounts photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/accounts';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;
        }
        $accounts = Accounts::create($data);
        return redirect()->back()->with('success', 'Successfully Create a new Accounts');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Accounts $accounts
     * @return  \Illuminate\Http\Response
     */
    public function show(Accounts $accounts, $id)
    {
        //Check authentication
        if (!Auth::user()->can('accounts.show')) {
            abort(403, 'Unauthorized Action');
        }
        $data['accounts'] = Accounts::findOrFail($id);
        return view('backend.accounts.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Accounts $accounts
     * @return  \Illuminate\Http\Response
     */
    public function edit(Accounts $accounts, $id)
    {
        //Check authentication
        if (!Auth::user()->can('accounts.update')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Accounts";
        $data['accounts'] = Accounts::findOrFail($id);
        return view('backend.accounts.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Accounts $accounts
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('accounts.update')) {
            abort(403, 'Unauthorized Action');
        }
        $checkAccounts = Accounts::findOrFail($id);

        $request->validate([
            'accounts' => ['required', 'string', 'min:3', 'max:255', 'unique:accountss,id,' . $request->id],
            'invoice_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_date' => ['nullable', 'string', 'min:3', 'max:255'],
            'amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'customer_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'supplier_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'purpose' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_method_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'remarks' => ['nullable', 'string', 'min:3', 'max:255'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ], [
            'invoice_id.required' => 'Please input invoice_id',
            'payment_date.required' => 'Please input payment_date',
            'amount.required' => 'Please input amount',
            'customer_id.required' => 'Please input customer_id',
            'supplier_id.required' => 'Please input supplier_id',
            'purpose.required' => 'Please input purpose',
            'payment_method_id.required' => 'Please input payment_method_id',
            'remarks.required' => 'Please input remarks',
        ]);
        $data['invoice_id'] = $request->invoice_id;
        $data['payment_date'] = $request->payment_date;
        $data['amount'] = $request->amount;
        $data['customer_id'] = $request->customer_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['purpose'] = $request->purpose;
        $data['payment_method_id'] = $request->payment_method_id;
        $data['remarks'] = $request->remarks;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //accounts photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/accounts';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;

            if (file_exists($checkAccounts->photo)) {
                unlink($checkAccounts->photo);
            }
        }

        DB::table('accountss')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success', 'Successfully Updated Accounts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Accounts $accounts
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Accounts $accounts)
    {
        //Check authentication
        if (!Auth::user()->can('accounts.delete')) {
            abort(403, 'Unauthorized Action');
        }
        $checkAccounts = Accounts::findOrFail($accounts->id);

        if (!is_null($accounts)) {
            $accounts->delete();
        }

        return redirect()->back()->with('success', 'Accounts Deleted Successfully');

    }
}

