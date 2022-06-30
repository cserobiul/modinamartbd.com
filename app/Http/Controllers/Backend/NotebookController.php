<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotebookController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('notebook.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Notebook";
        $data['notebooks'] = Notebook::where('status','active')->orderBy('created_at','DESC')->get();
        return view('backend.notebook.create',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('notebook.create')){
            abort(403,'Unauthorized Action');
        }
        return view('backend.notebook.create');
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
        if (!Auth::user()->can('notebook.create')){
            abort(403,'Unauthorized Action');
        }
        $request->validate([
            'title' => ['required','string','min:10','max:100'],
            'phone' => ['required','string','min:10','max:20'],
            'details' => ['required','string','min:10','max:5000'],
        ],[
            'title.required' => 'Please input title',
            'phone.required' => 'Please input phone',
            'details.required' => 'Please input details',
        ]);
        $data['title'] = $request->title;
        $data['phone'] = $request->phone;
        $data['details'] = $request->details;

        //who create this !?
        $data['user_id'] = Auth::user()->id;

        //notebook photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/notebook';
            $file_name = 'note_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }
        $notebook = Notebook::create($data);
        return redirect()->back()->with('success','Successfully Create a new Note');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Notebook  $notebook
     * @return  \Illuminate\Http\Response
     */
    public function show(Notebook $notebook)
    {
        //Check authentication
        if (!Auth::user()->can('notebook.show')){
            abort(403,'Unauthorized Action');
        }
        $data['notebook'] = Notebook::findOrFail($notebook->id);
        return view('backend.notebook.show',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Notebook  $notebook
     * @return  \Illuminate\Http\Response
     */
    public function edit(Notebook $notebook)
    {
        //Check authentication
        if (!Auth::user()->can('notebook.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Notebook";
        $data['notebook'] = Notebook::findOrFail($notebook->id);
        $data['notebooks'] = Notebook::orderBy('created_at','DESC')->get();
        return view('backend.notebook.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Notebook  $notebook
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('notebook.update')){
            abort(403,'Unauthorized Action');
        }
        $checkNotebook = Notebook::findOrFail($id);

        $request->validate([
            'title' => ['required','string','min:10','max:100'],
            'phone' => ['required','string','min:10','max:20'],
            'details' => ['required','string','min:10','max:5000'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif','max:2048'],
        ],[
            'title.required' => 'Please input title',
            'phone.required' => 'Please input phone',
            'details.required' => 'Please input details',
        ]);
        $data['title'] = $request->title;
        $data['phone'] = $request->phone;
        $data['details'] = $request->details;
        $data['status'] = $request->status;

        //who create this !?
        $data['user_id'] = Auth::user()->id;

        //notebook photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'frontend/images/notebook';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkNotebook->photo)){
                unlink($checkNotebook->photo);
            }
        }

        DB::table('notebooks')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Note Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Notebook  $notebook
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Notebook $notebook)
    {
        //Check authentication
        if (!Auth::user()->can('notebook.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkNotebook = Notebook::findOrFail($notebook->id);

        if (!is_null($notebook)){
            $notebook->delete();
        }

        return redirect()->back()->with('success','Note Deleted Successfully');

    }
}

