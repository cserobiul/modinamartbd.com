<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('slider.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Slider";
        $data['sliders'] = Slider::orderBy('created_at','DESC')->simplePaginate(50);
        return view('backend.slider.create',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('slider.create')){
            abort(403,'Unauthorized Action');
        }
        return redirect()>route('slider.index');
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
        if (!Auth::user()->can('slider.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'title' => ['required','string','min:3','max:255'],
            'order' => ['required','string','min:1','max:255'],
            'url' => ['nullable','string','min:3','max:255'],
            'photo' => ['required','mimes:jpeg,jpg,png,gif,svg','max:1024'],
        ],[
            'title.required' => 'Please input title',
            'photo.required' => 'Please upload a photo',
        ]);
        $data['title'] = $request->title;
        $data['order'] = $request->order;
        $data['url'] = $request->url;

        //who create this !?
        $data['user_id'] = Auth::user()->id;

        //slider photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/slider';
            $file_name = 'slider_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $slider = Slider::create($data);
        return redirect()->back()->with('success','Successfully Create a new Slider');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Slider  $slider
     * @return  \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //Check authentication
        if (!Auth::user()->can('slider.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()>route('slider.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Slider  $slider
     * @return  \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //Check authentication
        if (!Auth::user()->can('slider.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Slider";
        $data['slider'] = Slider::findOrFail($slider->id);
        $data['sliders'] = Slider::orderBy('created_at','DESC')->paginate(50);
        return view('backend.slider.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Slider  $slider
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('slider.update')){
            abort(403,'Unauthorized Action');
        }
        $checkSlider = Slider::findOrFail($id);

        $request->validate([
            'title' => ['required','string','min:3','max:255'],
            'order' => ['required','string','min:1','max:255'],
            'url' => ['nullable','string','min:3','max:255'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif,svg','max:512'],
        ],[
            'title.required' => 'Please input title',
            'photo.required' => 'Please input photo',
        ]);
        $data['title'] = $request->title;
        $data['order'] = $request->order;
        $data['url'] = $request->url;
        $data['status'] = $request->status;

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //slider photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/slider';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkSlider->photo)){
                unlink($checkSlider->photo);
            }
        }

        DB::table('sliders')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Slider');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Slider  $slider
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //Check authentication
        if (!Auth::user()->can('slider.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkSlider = Slider::findOrFail($slider->id);

        if (!is_null($slider)){
            $slider->delete();
        }

        return redirect()->back()->with('success','Slider Deleted Successfully');

    }
}

