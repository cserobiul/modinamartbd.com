<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SaleDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleDetailsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('saledetails.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "SaleDetails";
        $data['saledetailss'] = SaleDetails::where('status','active')->orderBy('created_at','DESC')->get();
        return view('backend.saledetails.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('saledetails.create')){
            abort(403,'Unauthorized Action');
        }
        return view('backend.saledetails.create');
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
        if (!Auth::user()->can('saledetails.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'sale_id' => ['nullable','string','min:3','max:255'],
            'product_id' => ['nullable','string','min:3','max:255'],
            'quantity' => ['nullable','string','min:3','max:255'],
            'price' => ['nullable','string','min:3','max:255'],
            'discount' => ['nullable','string','min:3','max:255'],
        ],[
            'sale_id.required' => 'Please input sale_id',
            'product_id.required' => 'Please input product_id',
            'quantity.required' => 'Please input quantity',
            'price.required' => 'Please input price',
            'discount.required' => 'Please input discount',
        ]);
        $data['sale_id'] = $request->sale_id;
        $data['product_id'] = $request->product_id;
        $data['quantity'] = $request->quantity;
        $data['price'] = $request->price;
        $data['discount'] = $request->discount;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$request->title))); // to get unique slug add...

        //dd($data);

        //saledetails photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/saledetails';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $saledetails = SaleDetails::create($data);
        return redirect()->back()->with('success','Successfully Create a new SaleDetails');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\SaleDetails  $saledetails
     * @return  \Illuminate\Http\Response
     */
    public function show(SaleDetails $saledetails,$id)
    {
        //Check authentication
        if (!Auth::user()->can('saledetails.show')){
            abort(403,'Unauthorized Action');
        }
        $data['saledetails'] = SaleDetails::findOrFail($id);
        return view('backend.saledetails.show',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\SaleDetails  $saledetails
     * @return  \Illuminate\Http\Response
     */
    public function edit(SaleDetails $saledetails)
    {
        //Check authentication
        if (!Auth::user()->can('saledetails.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "SaleDetails";
        $data['saledetails'] = SaleDetails::findOrFail($id);
        return view('backend.saledetails.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\SaleDetails  $saledetails
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('saledetails.update')){
            abort(403,'Unauthorized Action');
        }
        $checkSaleDetails = SaleDetails::findOrFail($id);

        $request->validate([
            'saledetails' => ['required','string', 'min:3','max:255','unique:saledetailss,id,'.$request->id],
            'sale_id' => ['nullable','string','min:3','max:255'],
            'product_id' => ['nullable','string','min:3','max:255'],
            'quantity' => ['nullable','string','min:3','max:255'],
            'price' => ['nullable','string','min:3','max:255'],
            'discount' => ['nullable','string','min:3','max:255'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif','max:2048'],
        ],[
            'sale_id.required' => 'Please input sale_id',
            'product_id.required' => 'Please input product_id',
            'quantity.required' => 'Please input quantity',
            'price.required' => 'Please input price',
            'discount.required' => 'Please input discount',
        ]);
        $data['sale_id'] = $request->sale_id;
        $data['product_id'] = $request->product_id;
        $data['quantity'] = $request->quantity;
        $data['price'] = $request->price;
        $data['discount'] = $request->discount;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$request->title))); // to get unique slug add...

        //saledetails photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/saledetails';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkSaleDetails->photo)){
                unlink($checkSaleDetails->photo);
            }
        }

        DB::table('saledetailss')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated SaleDetails');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\SaleDetails  $saledetails
     * @return  \Illuminate\Http\Response
     */
    public function destroy(SaleDetails $saledetails)
    {
        //Check authentication
        if (!Auth::user()->can('saledetails.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkSaleDetails = SaleDetails::findOrFail($saledetails->id);

        if (!is_null($saledetails)){
            $saledetails->delete();
        }

        return redirect()->back()->with('success','SaleDetails Deleted Successfully');

    }
}

