<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('supplier.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Supplier";
        $data['suppliers'] = Supplier::orderBy('created_at','DESC')->get();
        return view('backend.supplier.create',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('supplier.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('supplier.index');
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
        if (!Auth::user()->can('supplier.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'name' => ['required','string', 'min:3','max:255'],
            'phone' => ['required', 'min:11','max:11','unique:suppliers'],
            'email' => ['required','string', 'min:10','max:50','unique:suppliers'],
            'address' => ['nullable','string','min:3','max:255'],
        ],[
            'name.required' => 'Please input name',
            'phone.required' => 'Please input phone',
            'email.required' => 'Please input email',
            'address.required' => 'Please input address',
        ]);
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;

        //who create this !?
        $data['user_id'] = Auth::user()->id;
        //supplier photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/supplier';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $supplier = Supplier::create($data);
        return redirect()->back()->with('success','Successfully Create a new Supplier');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Supplier  $supplier
     * @return  \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //Check authentication
        if (!Auth::user()->can('supplier.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('supplier.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Supplier  $supplier
     * @return  \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //Check authentication
        if (!Auth::user()->can('supplier.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Supplier";
        $data['supplier'] = Supplier::findOrFail($supplier->id);
        $data['suppliers'] = Supplier::orderBy('created_at','DESC')->get();
        return view('backend.supplier.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Supplier  $supplier
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('supplier.update')){
            abort(403,'Unauthorized Action');
        }
        $checkSupplier = Supplier::findOrFail($id);

        $request->validate([
            'name' => ['required','string', 'min:3','max:255'],
            'phone' => ['required','string','min:11','max:11','unique:suppliers,id,'.$request->id],
            'email' => ['required','string','min:10','max:50','unique:suppliers,id,'.$request->id],
            'address' => ['nullable','string','min:3','max:255'],
        ],[
            'name.required' => 'Please input name',
            'phone.required' => 'Please input phone',
            'email.required' => 'Please input email',
            'address.required' => 'Please input address',
        ]);
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['status'] = $request->status;

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //supplier photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/supplier';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkSupplier->photo)){
                unlink($checkSupplier->photo);
            }
        }

        DB::table('suppliers')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Supplier');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Supplier  $supplier
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //Check authentication
        if (!Auth::user()->can('supplier.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkSupplier = Supplier::findOrFail($supplier->id);

        if (!is_null($supplier)){
            $supplier->delete();
        }

        return redirect()->back()->with('success','Supplier Deleted Successfully');

    }
}

