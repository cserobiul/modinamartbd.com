<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarrantyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('warranty.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Warranty";
        $data['warranties'] = Warranty::orderBy('created_at','DESC')->get();
        return view('backend.warranty.create',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('warranty.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('warranty.index');
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
        if (!Auth::user()->can('warranty.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'warranty_name' => ['nullable','string','min:1','max:30','unique:warranties'],
        ],[
            'warranty_name.required' => 'Please input Warranty Name',
        ]);
        $data['warranty_name'] = $request->warranty_name;

        //who create this Warranty !?
        $data['user_id'] = Auth::user()->id;

        //dd($data);

        //warranty photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/warranty';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $warranty = Warranty::create($data);
        return redirect()->back()->with('success','Successfully Create a new Warranty');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Warranty  $warranty
     * @return  \Illuminate\Http\Response
     */
    public function show(Warranty $warranty)
    {
        //Check authentication
        if (!Auth::user()->can('warranty.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('warranty.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Warranty  $warranty
     * @return  \Illuminate\Http\Response
     */
    public function edit(Warranty $warranty)
    {
        //Check authentication
        if (!Auth::user()->can('warranty.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Warranty";
        $data['warranties'] = Warranty::orderBy('created_at','DESC')->get();
        $data['warranty'] = Warranty::findOrFail($warranty->id);
        return view('backend.warranty.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Warranty  $warranty
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('warranty.update')){
            abort(403,'Unauthorized Action');
        }
        $checkWarranty = Warranty::findOrFail($id);

        $request->validate([
            'warranty_name' => ['required', 'min:1','max:30','unique:warranties,id,'.$request->id],
            'status' => ['required', 'min:3','max:20']
        ],[
            'warranty_name.required' => 'Please input Warranty Name',
        ]);
        $data['warranty_name'] = $request->warranty_name;
        $data['status'] = $request->status;

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //warranty photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/warranty';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkWarranty->photo)){
                unlink($checkWarranty->photo);
            }
        }

        DB::table('warranties')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Warranty');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Warranty  $warranty
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Warranty $warranty)
    {
        //Check authentication
        if (!Auth::user()->can('warranty.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkWarranty = Warranty::findOrFail($warranty->id);

        if (!is_null($warranty)){
            $warranty->delete();
        }

        return redirect()->back()->with('success','Warranty Deleted Successfully');

    }
}

