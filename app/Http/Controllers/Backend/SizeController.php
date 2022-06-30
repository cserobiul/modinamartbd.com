<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('size.all')){
            abort(403,'Unauthorized Action');
        }

        $data['pageTitle'] = "Size";
        $data['sizes'] = Size::orderBy('created_at','DESC')->get();
        return view('backend.size.create',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('size.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('size.index');
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
        if (!Auth::user()->can('size.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'size_name' => ['required','string','min:1','max:20','unique:sizes']
        ],[
            'size_name.required' => 'Please input Size Name',
        ]);
        $data['size_name'] = $request->size_name;

        //who create this !?
        $data['user_id'] = Auth::user()->id;

        //size photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/size';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $size = Size::create($data);
        return redirect()->back()->with('success','Successfully Create a new Size');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Size  $size
     * @return  \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //Check authentication
        if (!Auth::user()->can('size.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('size.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Size  $size
     * @return  \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {
        //Check authentication
        if (!Auth::user()->can('size.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Size";
        $data['sizes'] = Size::orderBy('created_at','DESC')->get();
        $data['size'] = Size::findOrFail($size->id);

        return view('backend.size.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Size  $size
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('size.update')){
            abort(403,'Unauthorized Action');
        }
        $checkSize = Size::findOrFail($id);

        $request->validate([
            'size_name' => ['required', 'min:1','max:20','unique:sizes,id,'.$request->id],
            'status' => ['required', 'min:3','max:20']
        ],[
            'size_name.required' => 'Please input Size Name',
        ]);
        $data['size_name'] = $request->size_name;
        $data['status'] = $request->status;

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //size photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/size';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkSize->photo)){
                unlink($checkSize->photo);
            }
        }

        DB::table('sizes')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Size');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Size  $size
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {
        //Check authentication
        if (!Auth::user()->can('size.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkSize = Size::findOrFail($size->id);

        if (!is_null($size)){
            $size->delete();
        }

        return redirect()->back()->with('success','Size Deleted Successfully');

    }
}

