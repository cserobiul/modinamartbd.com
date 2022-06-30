<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('payment_method.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = 'Payment Method';
        $data['paymentmethods'] = PaymentMethod::orderBy('created_at','DESC')->get();
        return view('backend.payment_method.create',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('payment_method.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('payment-method.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('payment_method.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'payment_name' => ['required','string','min:3','max:50','unique:payment_methods'],
            'details' => ['required','string','min:6','max:255'],
        ],[
            'payment_name.required' => 'Please input payment method name',
        ]);
        $data['payment_name'] = $request->payment_name;
        $data['details'] = $request->details;

        //who create this Payment Method !?
        $data['user_id'] = Auth::user()->id;

        //dd($data);

        //paymentmethod photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/paymentmethod';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $paymentmethod = PaymentMethod::create($data);
        return redirect()->back()->with('success','Successfully Create a new PaymentMethod');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\PaymentMethod  $paymentmethod
     * @return  \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentmethod)
    {
        //Check authentication
        if (!Auth::user()->can('payment_method.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('payment-method.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\PaymentMethod  $paymentmethod
     * @return  \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentmethod,$id)
    {
        //Check authentication
        if (!Auth::user()->can('payment_method.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = 'Payment Method';
        $data['paymentmethods'] = PaymentMethod::orderBy('created_at','DESC')->get();
        $data['paymentmethod'] = PaymentMethod::findOrFail($id);

        return view('backend.payment_method.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\PaymentMethod  $paymentmethod
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('payment_method.update')){
            abort(403,'Unauthorized Action');
        }
        $checkPaymentMethod = PaymentMethod::findOrFail($id);

        $request->validate([
            'payment_name' => ['required','string', 'min:3','max:50','unique:payment_methods,id,'.$request->id],
            'details' => ['required','string','min:6','max:255'],
        ],[
            'payment_name.required' => 'Please input payment name',
        ]);
        $data['payment_name'] = $request->payment_name;
        $data['details'] = $request->details;
        $data['status'] = $request->status;

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //paymentmethod photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/payment_method';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkPaymentMethod->photo)){
                unlink($checkPaymentMethod->photo);
            }
        }

        DB::table('payment_methods')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated PaymentMethod');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\PaymentMethod  $paymentmethod
     * @return  \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentmethod)
    {
        //Check authentication
        if (!Auth::user()->can('payment_method.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkPaymentMethod = PaymentMethod::findOrFail($paymentmethod->id);

        if (!is_null($paymentmethod)){
            $paymentmethod->delete();
        }

        return redirect()->back()->with('success','PaymentMethod Deleted Successfully');

    }
}

