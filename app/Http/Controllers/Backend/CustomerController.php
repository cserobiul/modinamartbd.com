<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('customer.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Customer";
        $data['customers'] = Customer::orderBy('created_at','DESC')->paginate(100);
        return view('backend.customer.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('customer.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
//        return view('backend.customer.create');
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
        if (!Auth::user()->can('customer.create')){
            abort(403,'Unauthorized Action');
        }

        return redirect()->route('dashboard');

        $request->validate([
            'customer_name' => ['nullable','string','min:3','max:255'],
            'phone' => ['nullable','string','min:3','max:255'],
            'email' => ['nullable','string','min:3','max:255'],
            'address' => ['nullable','string','min:3','max:255'],
            'district' => ['nullable','string','min:3','max:255'],
        ],[
            'customer_name.required' => 'Please input customer_name',
            'phone.required' => 'Please input phone',
            'email.required' => 'Please input email',
            'address.required' => 'Please input address',
            'district.required' => 'Please input district',
        ]);
        $data['customer_name'] = $request->customer_name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['district'] = $request->district;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$request->title))); // to get unique slug add...

        //dd($data);

        //customer photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/customer';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $customer = Customer::create($data);
        return redirect()->back()->with('success','Successfully Create a new Customer');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Customer  $customer
     * @return  \Illuminate\Http\Response
     */
    public function show(Customer $customer,$id)
    {
        //Check authentication
        if (!Auth::user()->can('customer.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
//        $data['customer'] = Customer::findOrFail($id);
//        return view('backend.customer.show',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Customer  $customer
     * @return  \Illuminate\Http\Response
     */
    public function edit(Customer $customer,$id)
    {
        //Check authentication
        if (!Auth::user()->can('customer.update')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('dashboard');
//        $data['pageTitle'] = "Customer";
//        $data['customer'] = Customer::findOrFail($id);
//        return view('backend.customer.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Customer  $customer
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('customer.update')){
            abort(403,'Unauthorized Action');
        }
        $checkCustomer = Customer::findOrFail($id);

        return redirect()->route('dashboard');

        $request->validate([
            'customer' => ['required','string', 'min:3','max:255','unique:customers,id,'.$request->id],
            'customer_name' => ['nullable','string','min:3','max:255'],
            'phone' => ['nullable','string','min:3','max:255'],
            'email' => ['nullable','string','min:3','max:255'],
            'address' => ['nullable','string','min:3','max:255'],
            'district' => ['nullable','string','min:3','max:255'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif','max:2048'],
        ],[
            'customer_name.required' => 'Please input customer_name',
            'phone.required' => 'Please input phone',
            'email.required' => 'Please input email',
            'address.required' => 'Please input address',
            'district.required' => 'Please input district',
        ]);
        $data['customer_name'] = $request->customer_name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['district'] = $request->district;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$request->title))); // to get unique slug add...

        //customer photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/customer';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkCustomer->photo)){
                unlink($checkCustomer->photo);
            }
        }

        DB::table('customers')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Customer');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Customer  $customer
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //Check authentication
        if (!Auth::user()->can('customer.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkCustomer = Customer::findOrFail($customer->id);
        return redirect()->route('dashboard');
//        if (!is_null($customer)){
//            $customer->delete();
//        }
//
//        return redirect()->back()->with('success','Customer Deleted Successfully');

    }
}

