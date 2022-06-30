<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('brand.all')) {
            abort(403, 'Unauthorized Action');
        }

        $data['brands'] = Brand::orderBy('created_at', 'DESC')->get();
        return view('backend.brand.create', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('brand.create')) {
            abort(403, 'Unauthorized Action');
        }
        return redirect()->route('brand.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('brand.create')) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'brand_name' => ['required', 'string', 'min:3', 'max:255', 'unique:brands'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg', 'max:512'],
        ], [
            'brand_name.required' => 'Please input Brand Name',
        ]);
        $data['brand_name'] = $request->brand_name;
        $data['slug'] = Settings::slugWithUnicode($data['brand_name']);

        //who create this brand !?
        $data['user_id'] = Auth::user()->id;

        //brand photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'assets/images/brand';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;
        }
        $brand = Brand::create($data);
        return redirect()->back()->with('success', 'Successfully Create a new Brand');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return  \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //Check authentication
        if (!Auth::user()->can('brand.show')) {
            abort(403, 'Unauthorized Action');
        }
        return redirect()->route('brand.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return  \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //Check authentication
        if (!Auth::user()->can('brand.update')) {
            abort(403, 'Unauthorized Action');
        }
        $data['brand'] = Brand::findOrFail($brand->id);
        $data['brands'] = Brand::orderBy('created_at', 'DESC')->get();
        return view('backend.brand.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Brand $brand
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('brand.update')) {
            abort(403, 'Unauthorized Action');
        }
        $checkBrand = Brand::findOrFail($id);

        $request->validate([
            'brand_name' => ['nullable', 'string', 'min:3', 'max:255', 'unique:brands,id,' . $request->id],
            'status' => ['required', 'min:3', 'max:20'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg', 'max:512'],
        ], [
            'brand_name.required' => 'Please input brand_name',
        ]);
        $data['brand_name'] = $request->brand_name;
        $data['status'] = $request->status;
        $data['slug'] = Settings::slugWithUnicode($data['brand_name']);

        //who update this !?
        $data['update_by'] = Auth::user()->id;

        //brand photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'assets/images/brand';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;

            if (file_exists($checkBrand->photo)) {
                unlink($checkBrand->photo);
            }
        }

        DB::table('brands')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success', 'Successfully Updated Brand');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Brand $brand
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //Check authentication
        if (!Auth::user()->can('brand.delete')) {
            abort(403, 'Unauthorized Action');
        }
        $checkBrand = Brand::findOrFail($brand->id);

        if (!is_null($brand)) {
            $brand->delete();
        }

        return redirect()->back()->with('success', 'Brand Deleted Successfully');

    }
}

