<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('category.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Category";

        return view('backend.category.create');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('category.create')){
            abort(403,'Unauthorized Action');
        }

        return redirect()->route('category.index');
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
        if (!Auth::user()->can('category.create')){
            abort(403,'Unauthorized Action');
        }

        $request->validate([
            'name' => ['required','string','min:3','max:255','unique:categories'],
            'order_sl' => ['required','min:1','max:255'],
            'parent_category_name' => ['nullable','min:1','max:3'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif,svg','max:512'],
        ],[
            'name.required' => 'Please input a Category Name',
        ]);
        $data['name'] = $request->name;
        $data['order_sl'] = $request->order_sl;
        $data['show_home'] = $request->show_home;
        $data['parent_id'] = $request->parent_category_name;
        $data['slug'] = Settings::slugWithUnicode($data['name']);

        $hasSlug = Category::where('slug',$data['slug'])->first();
        if ($hasSlug){
            $data['slug'] = $data['slug'].'_'. rand( 0, time() );
        }
        //who create this category !?
        $data['user_id'] = Auth::user()->id;
        //category photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/category';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;
        }

        $category = Category::create($data);
        return redirect()->back()->with('success','Successfully Create a new Category');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Category  $category
     * @return  \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //Check authentication
        if (!Auth::user()->can('category.show')){
            abort(403,'Unauthorized Action');
        }
        return redirect()->route('category.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Category  $category
     * @return  \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //Check authentication
        if (!Auth::user()->can('category.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Category";
        $data['category'] = Category::findOrFail($category->id);
        return view('backend.category.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Category  $category
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('category.update')){
            abort(403,'Unauthorized Action');
        }
        $checkCategory = Category::findOrFail($id);

        $request->validate([
            'name' => ['required','string', 'min:3','max:255','unique:categories,id,'.$request->id],
            'slug' => ['required','string', 'min:3','max:255','unique:categories,id,'.$request->id],
            'order_sl' => ['required','string','min:1','max:255'],
            'parent_category_name' => ['nullable','string','min:1','max:255'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif,svg','max:512'],
        ],[
            'name.required' => 'Please input name',
            'slug.required' => 'Please input slug',
            'parent_category_name.min' => 'Please select parent category name',
        ]);
        $data['name'] = $request->name;
        $data['slug'] = $request->slug;
        $data['order_sl'] = $request->order_sl;
        $data['show_home'] = $request->show_home;
        $data['parent_id'] = $request->parent_category_name;
        $data['status'] = $request->status;

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //category photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/category';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists($checkCategory->photo)){
                unlink($checkCategory->photo);
            }
        }

        DB::table('categories')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Category');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Category  $category
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //Check authentication
        if (!Auth::user()->can('category.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkCategory = Category::findOrFail($category->id);

        if (!is_null($category)){
            $category->delete();
        }

        return redirect()->back()->with('success','Category Deleted Successfully');

    }
}

