<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuyerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('buyer.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Buyer";
        $data['buyers'] = Buyer::where('status','active')->orderBy('created_at','DESC')->get();
        return view('backend.buyer.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('buyer.create')){
            abort(403,'Unauthorized Action');
        }
        return view('backend.buyer.create');
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
        if (!Auth::user()->can('buyer.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'name' => ['nullable','string','min:3','max:255'],
            'phone' => ['nullable','string','min:3','max:255'],
            'email' => ['nullable','string','min:3','max:255'],
            'address' => ['nullable','string','min:3','max:255'],
            'buy_amount' => ['nullable','string','min:3','max:255'],
            'paid_payment' => ['nullable','string','min:3','max:255'],
            'current_due' => ['nullable','string','min:3','max:255'],
        ],[
            'name.required' => 'Please input name',
            'phone.required' => 'Please input phone',
            'email.required' => 'Please input email',
            'address.required' => 'Please input address',
            'buy_amount.required' => 'Please input buy_amount',
            'paid_payment.required' => 'Please input paid_payment',
            'current_due.required' => 'Please input current_due',
        ]);
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['buy_amount'] = $request->buy_amount;
        $data['paid_payment'] = $request->paid_payment;
        $data['current_due'] = $request->current_due;
        $data['status'] = $request->status;


        //dd($data);

        //buyer photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/buyer';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $buyer = Buyer::create($data);
        return redirect()->back()->with('success','Successfully Create a new Buyer');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Buyer  $buyer
     * @return  \Illuminate\Http\Response
     */
    public function show(Buyer $buyer,$id)
    {
        //Check authentication
        if (!Auth::user()->can('buyer.show')){
            abort(403,'Unauthorized Action');
        }
        $data['buyer'] = Buyer::findOrFail($id);
        return view('backend.buyer.show',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Buyer  $buyer
     * @return  \Illuminate\Http\Response
     */
    public function edit(Buyer $buyer)
    {
        //Check authentication
        if (!Auth::user()->can('buyer.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Buyer";
        $data['buyer'] = Buyer::findOrFail($id);
        return view('backend.buyer.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Buyer  $buyer
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('buyer.update')){
            abort(403,'Unauthorized Action');
        }
        $checkBuyer = Buyer::findOrFail($id);

        $request->validate([
            'buyer' => ['required','string', 'min:3','max:255','unique:buyers,id,'.$request->id],
            'name' => ['nullable','string','min:3','max:255'],
            'phone' => ['nullable','string','min:3','max:255'],
            'email' => ['nullable','string','min:3','max:255'],
            'address' => ['nullable','string','min:3','max:255'],
            'buy_amount' => ['nullable','string','min:3','max:255'],
            'paid_payment' => ['nullable','string','min:3','max:255'],
            'current_due' => ['nullable','string','min:3','max:255'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif','max:2048'],
        ],[
            'name.required' => 'Please input name',
            'phone.required' => 'Please input phone',
            'email.required' => 'Please input email',
            'address.required' => 'Please input address',
            'buy_amount.required' => 'Please input buy_amount',
            'paid_payment.required' => 'Please input paid_payment',
            'current_due.required' => 'Please input current_due',
        ]);
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['buy_amount'] = $request->buy_amount;
        $data['paid_payment'] = $request->paid_payment;
        $data['current_due'] = $request->current_due;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$request->title))); // to get unique slug add...

        //buyer photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/buyer';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkBuyer->photo)){
                unlink($checkBuyer->photo);
            }
        }

        DB::table('buyers')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Buyer');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Buyer  $buyer
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer)
    {
        //Check authentication
        if (!Auth::user()->can('buyer.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkBuyer = Buyer::findOrFail($buyer->id);

        if (!is_null($buyer)){
            $buyer->delete();
        }

        return redirect()->back()->with('success','Buyer Deleted Successfully');

    }
}

