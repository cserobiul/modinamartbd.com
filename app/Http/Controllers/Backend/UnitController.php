<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('unit.all')){
            abort(403,'Unauthorized Action');
        }

        $data['pageTitle'] = 'Unit';
        $data['units'] = Unit::orderBy('created_at','DESC')->get();
        return view('backend.unit.create',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('unit.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('unit.index');
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
        if (!Auth::user()->can('unit.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'unit_name' => ['nullable','string','min:2','max:255','unique:units']
        ],[
            'unit_name.required' => 'Please input Unit Name',
        ]);
        $data['unit_name'] = $request->unit_name;

        //who create this Unit !?
        $data['user_id'] = Auth::user()->id;

        //unit photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/unit';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $unit = Unit::create($data);
        return redirect()->back()->with('success','Successfully Create a new Unit');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Unit  $unit
     * @return  \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //Check authentication
        if (!Auth::user()->can('unit.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('unit.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Unit  $unit
     * @return  \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //Check authentication
        if (!Auth::user()->can('unit.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = 'Unit';
        $data['units'] = Unit::orderBy('created_at','DESC')->get();
        $data['unit'] = Unit::findOrFail($unit->id);
        return view('backend.unit.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Unit  $unit
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('unit.update')){
            abort(403,'Unauthorized Action');
        }
        $checkUnit = Unit::findOrFail($id);

        $request->validate([
            'unit_name' => ['required', 'min:3','max:255','unique:units,id,'.$request->id],
            'status' => ['required', 'min:3','max:20']
        ],[
            'unit_name.required' => 'Please input Unit Name',
        ]);
        $data['unit_name'] = $request->unit_name;
        $data['status'] = $request->status;

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //unit photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/unit';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkUnit->photo)){
                unlink($checkUnit->photo);
            }
        }

        DB::table('units')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Unit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Unit  $unit
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //Check authentication
        if (!Auth::user()->can('unit.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkUnit = Unit::findOrFail($unit->id);

        if (!is_null($unit)){
            $unit->delete();
        }

        return redirect()->back()->with('success','Unit Deleted Successfully');

    }
}

