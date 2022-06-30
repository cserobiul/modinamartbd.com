<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\SaleTransaction;
use App\Models\Settings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session;

class SaleTransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('saletransaction.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "SaleTransaction";
        $data['saletransactions'] = SaleTransaction::where('status', 'active')->orderBy('created_at', 'DESC')->get();
        return view('backend.saletransaction.index', $data);

    }


    public function buyerDueCollection()
    {
        //Check authentication
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['pageTitle'] = 'Due Collection';
        $data['invoice_id'] = Settings::saleInvoiceGenerator();


        return view('backend.accounts.buyer_due_collection', $data);
    }

    public function buyerDueCollectionProcess(Request $request)
    {
        //dd($request->all());
        //Check authentication
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }
        //who create this !?
        $data['user_id'] = Auth::user()->id;

        $buyerData = Buyer::where('id', $request->name)->first();

        if ($buyerData) {
            $data['invoice_no'] = $request->invoice_no;
            $data['payment_date'] = $request->payment_date;
            $data['buyer_id'] = $buyerData->id;

            DB::beginTransaction();
            try {
                if ($request->amount > 0) {
                    $data['amount'] = $request->amount;
                    $data['purpose'] = Settings::SALE_DUE_PAYMENT;
                    $data['payment_method_id'] = $request->payment_method;
                    SaleTransaction::create($data);
                }

                $checkDue = $buyerData->current_due - $request->amount;

                //Buyer Table
                $dataBuyer['paid_payment'] = $buyerData->paid_payment + $request->amount;
                $dataBuyer['current_due'] = $buyerData->current_due - $request->amount;
                DB::table('buyers')->where('id', $request->name)->update($dataBuyer);

                DB::commit();

            } catch (\Exception $exception) {
//                echo '<pre>';
                return $exception->getMessage();
                DB::rollBack();
                return back()->with('warning', 'Something error, please contact support.');
            }

        } else {
            return redirect()->route('buyerDueCollection')->with('warning', 'Customer data does not match...');
        }

        return redirect()->route('buyerDueCollection')
            ->with('success', 'Successfully Due Collect for ' . Settings::unicodeName($buyerData->name));
    }

    public function buyerDueCheck($buyerId)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $data['buyer'] = Buyer::where('id', $buyerId)->first();
        if ($data['buyer']) {
            return ($data['buyer']->current_due == !null ? $data['buyer']->current_due : 0);
        } else {
            return 0;
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('saletransaction.create')) {
            abort(403, 'Unauthorized Action');
        }
        return view('backend.saletransaction.create');
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
        if (!Auth::user()->can('saletransaction.create')) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'sale_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_date' => ['nullable', 'string', 'min:3', 'max:255'],
            'buyer_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'purpose' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_method_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'transaction_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'remarks' => ['nullable', 'string', 'min:3', 'max:255'],
        ], [
            'sale_id.required' => 'Please input sale_id',
            'payment_date.required' => 'Please input payment_date',
            'buyer_id.required' => 'Please input buyer_id',
            'amount.required' => 'Please input amount',
            'purpose.required' => 'Please input purpose',
            'payment_method_id.required' => 'Please input payment_method_id',
            'transaction_id.required' => 'Please input transaction_id',
            'remarks.required' => 'Please input remarks',
        ]);
        $data['sale_id'] = $request->sale_id;
        $data['payment_date'] = $request->payment_date;
        $data['buyer_id'] = $request->buyer_id;
        $data['amount'] = $request->amount;
        $data['purpose'] = $request->purpose;
        $data['payment_method_id'] = $request->payment_method_id;
        $data['transaction_id'] = $request->transaction_id;
        $data['remarks'] = $request->remarks;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //dd($data);

        //saletransaction photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/saletransaction';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;
        }
        $saletransaction = SaleTransaction::create($data);
        return redirect()->back()->with('success', 'Successfully Create a new SaleTransaction');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SaleTransaction $saletransaction
     * @return  \Illuminate\Http\Response
     */
    public function show(SaleTransaction $saletransaction, $id)
    {
        //Check authentication
        if (!Auth::user()->can('saletransaction.show')) {
            abort(403, 'Unauthorized Action');
        }
        $data['saletransaction'] = SaleTransaction::findOrFail($id);
        return view('backend.saletransaction.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\SaleTransaction $saletransaction
     * @return  \Illuminate\Http\Response
     */
    public function edit(SaleTransaction $saletransaction)
    {
        //Check authentication
        if (!Auth::user()->can('saletransaction.update')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "SaleTransaction";
        $data['saletransaction'] = SaleTransaction::findOrFail($id);
        return view('backend.saletransaction.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SaleTransaction $saletransaction
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('saletransaction.update')) {
            abort(403, 'Unauthorized Action');
        }
        $checkSaleTransaction = SaleTransaction::findOrFail($id);

        $request->validate([
            'saletransaction' => ['required', 'string', 'min:3', 'max:255', 'unique:saletransactions,id,' . $request->id],
            'sale_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_date' => ['nullable', 'string', 'min:3', 'max:255'],
            'buyer_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'amount' => ['nullable', 'string', 'min:3', 'max:255'],
            'purpose' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_method_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'transaction_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'remarks' => ['nullable', 'string', 'min:3', 'max:255'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ], [
            'sale_id.required' => 'Please input sale_id',
            'payment_date.required' => 'Please input payment_date',
            'buyer_id.required' => 'Please input buyer_id',
            'amount.required' => 'Please input amount',
            'purpose.required' => 'Please input purpose',
            'payment_method_id.required' => 'Please input payment_method_id',
            'transaction_id.required' => 'Please input transaction_id',
            'remarks.required' => 'Please input remarks',
        ]);
        $data['sale_id'] = $request->sale_id;
        $data['payment_date'] = $request->payment_date;
        $data['buyer_id'] = $request->buyer_id;
        $data['amount'] = $request->amount;
        $data['purpose'] = $request->purpose;
        $data['payment_method_id'] = $request->payment_method_id;
        $data['transaction_id'] = $request->transaction_id;
        $data['remarks'] = $request->remarks;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //saletransaction photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/saletransaction';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;

            if (file_exists($checkSaleTransaction->photo)) {
                unlink($checkSaleTransaction->photo);
            }
        }

        DB::table('saletransactions')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success', 'Successfully Updated SaleTransaction');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SaleTransaction $saletransaction
     * @return  \Illuminate\Http\Response
     */
    public function destroy(SaleTransaction $saletransaction)
    {
        //Check authentication
        if (!Auth::user()->can('saletransaction.delete')) {
            abort(403, 'Unauthorized Action');
        }
        $checkSaleTransaction = SaleTransaction::findOrFail($saletransaction->id);

        if (!is_null($saletransaction)) {
            $saletransaction->delete();
        }

        return redirect()->back()->with('success', 'SaleTransaction Deleted Successfully');

    }
}

