<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('color.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Color";
        $data['colors'] = Color::orderBy('created_at','DESC')->get();
        return view('backend.color.create',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('color.create')){
            abort(403,'Unauthorized Action');
        }
        return view('backend.color.create');
        return redirect()->route('color.index');
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
        if (!Auth::user()->can('color.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'color_name' => ['required','string','min:3','max:40'],
            'color_code' => ['required','string','min:3','max:20']
        ],[
            'color_name.required' => 'Please input color name',
        ]);
        $data['color_name'] = $request->color_name;
        $data['color_code'] = $request->color_code;

        //who create this Color !?
        $data['user_id'] = Auth::user()->id;

        //color photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/color';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $color = Color::create($data);
        return redirect()->back()->with('success','Successfully Create a new Color');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Color  $color
     * @return  \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //Check authentication
        if (!Auth::user()->can('color.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('color.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Color  $color
     * @return  \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
        //Check authentication
        if (!Auth::user()->can('color.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Color";
        $data['color'] = Color::findOrFail($color->id);
        $data['colors'] = Color::orderBy('created_at','DESC')->get();
        return view('backend.color.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Color  $color
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('color.update')){
            abort(403,'Unauthorized Action');
        }
        $checkColor = Color::findOrFail($id);

        $request->validate([
            'color_name' => ['required','string', 'min:3','max:255','unique:colors,id,'.$request->id],
            'color_code' => ['nullable','string','min:3','max:255'],
        ],[
            'color_name.required' => 'Please input color name',
        ]);
        $data['color_name'] = $request->color_name;
        $data['color_code'] = $request->color_code;
        $data['status'] = $request->status;

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //color photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/color';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkColor->photo)){
                unlink($checkColor->photo);
            }
        }

        DB::table('colors')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Color');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Color  $color
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        //Check authentication
        if (!Auth::user()->can('color.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkColor = Color::findOrFail($color->id);

        if (!is_null($color)){
            $color->delete();
        }

        return redirect()->back()->with('success','Color Deleted Successfully');

    }
}

