<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Productphoto;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('product.all')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Product";
        $data['products'] = Product::orderBy('created_at','DESC')->simplePaginate(100);
        return view('backend.product.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('product.create')){
            abort(403,'Unauthorized Action');
        }

        return view('backend.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        //Check authentication
        if (!Auth::user()->can('product.create')){
            abort(403,'Unauthorized Action');
        }
        $request->validate([
            'name' => ['required','string','min:3','max:255','unique:products'],
            'code' => ['nullable','string','min:3','max:255'],
            'point' => ['required','string','min:3','max:255'],
            'category_name' => ['required','string','min:1','max:255'],
            'brand_name' => ['required','string','min:1','max:255'],
            'unit_name' => ['nullable','string','min:1','max:255'],
            'warranty_name' => ['nullable','string','min:1','max:255'],
            'sale_price' => ['nullable','string','min:1','max:9999999'],
            'wholesale_price' => ['nullable','string','min:1','max:9999999'],
            'discount_amount' => ['nullable','string','min:1','max:9999999'],
            'has_stock' => ['nullable','string','min:1','max:255'],
            'view_section' => ['nullable','string','min:3','max:255'],
            'excerpts' => ['nullable','string','min:10','max:1000'],
            'details' => ['nullable','string','min:10','max:3000'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif,svg','max:512'],
            'multiple_photo.*' => ['nullable','mimes:jpeg,jpg,png,gif,svg','max:5120'],
        ],[
            'name.required' => 'Please input name',
        ]);

        DB::beginTransaction();
        try {
            $data['name'] = $request->name;
            $data['code'] = $request->code;
            $data['point'] = $request->point;
            $data['category_id'] = $request->category_name;
            $data['brand_id'] = $request->brand_name;
            $data['unit_id'] = $request->unit_name;
            $data['warranty_id'] = 1;
//            $data['warranty_id'] = $request->warranty_name;
            $data['sale_price'] = $request->sale_price;
            $data['wholesale_price'] = $request->wholesale_price;
            $data['slug'] =  Settings::slugWithUnicode($data['name']);
            $data['discount_type'] = $request->discount_type;
            $data['discount_amount'] = $request->discount_amount;
            $data['discount_percentage'] = $request->discount_percentage;
            $data['has_stock'] = $request->has_stock;
            $data['view_section'] = $request->view_section;
            $data['excerpts'] = $request->excerpts;
            $data['details'] = $request->details;

            //who create this !?
            $data['user_id'] = Auth::user()->id;
            //product photo
            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $path = 'assets/images/product';
                $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
                $file->move(public_path($path),$file_name);
                $data['photo'] = $path.'/'.$file_name;
            }
            $product = Product::create($data);


            //multiple photo upload
            if($request->hasFile('multiple_photo')){
                foreach ($request->multiple_photo as $img){
                    $path = 'assets/images/product';
                    $file_name = 'photo_'.rand(000000000,999999999).'.'.$img->getClientOriginalExtension();
                    $img->move(public_path($path),$file_name);

                    Productphoto::create([
                       'product_id' => $product->id,
                       'photo' => $path.'/'.$file_name,
                    ]);
                }
            }

            DB::commit();

        }catch (\Exception $exception){
            DB::rollBack();
            echo '<pre>';
            return $exception->getMessage();

            return back()->with('warning', 'Something error, please contact support.' );
        }

        return redirect()->back()->with('success','Successfully Create a new Product');
    }

    /**
     * Display the specified resource.
     *
     * @param    \App\Models\Product  $product
     * @return  \Illuminate\Http\Response
     */
    public function show(Product $product,$id)
    {
        //Check authentication
        if (!Auth::user()->can('product.show')){
            abort(403,'Unauthorized Action');
        }
        $data['product'] = Product::findOrFail($id);
        return view('backend.product.show',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    \App\Models\Product  $product
     * @return  \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //Check authentication
        if (!Auth::user()->can('product.update')){
            abort(403,'Unauthorized Action');
        }
        $data['pageTitle'] = "Product";
        $data['product'] = Product::findOrFail($product->id);
        $data['productPhotos'] = Productphoto::where('product_id',$data['product']->id)->get();
        return view('backend.product.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    \App\Models\Product  $product
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        //Check authentication
        if (!Auth::user()->can('product.update')){
            abort(403,'Unauthorized Action');
        }
        $checkProduct = Product::findOrFail($id);

        $request->validate([
            'name' => ['required','string', 'min:3','max:255','unique:products,id,'.$request->id],
            'slug' => ['required','string', 'min:3','max:255','unique:products,id,'.$request->id],
            'code' => ['nullable','string','min:3','max:255'],
            'point' => ['required','string','min:1','max:10000'],
            'category_name' => ['required','string','min:1','max:255'],
            'brand_name' => ['required','string','min:1','max:255'],
            'unit_name' => ['nullable','string','min:1','max:255'],
            'warranty_name' => ['nullable','string','min:1','max:255'],
            'sale_price' => ['nullable','string','min:1','max:9999999'],
            'wholesale_price' => ['nullable','string','min:1','max:9999999'],
            'discount_amount' => ['nullable','string','min:1','max:9999999'],
            'has_stock' => ['nullable','string','min:1','max:255'],
            'view_section' => ['nullable','string','min:3','max:255'],
            'excerpts' => ['nullable','string','min:10','max:512'],
            'details' => ['nullable','string','min:10','max:3000'],
            'photo' => ['nullable','mimes:jpeg,jpg,png,gif,svg','max:512'],
        ],[
            'name.required' => 'Please input name',
            'code.required' => 'Please input code',
        ]);
        $data['name'] = $request->name;
        $data['code'] = $request->code;
        $data['point'] = $request->point;
        $data['category_id'] = $request->category_name;
        $data['brand_id'] = $request->brand_name;
        $data['unit_id'] = $request->unit_name;
        $data['warranty_id'] = $request->warranty_name;
        $data['sale_price'] = $request->sale_price;
        $data['wholesale_price'] = $request->wholesale_price;
        $data['slug'] =  Settings::slugWithUnicode($request['slug']);
        $data['discount_type'] = $request->discount_type;
        $data['discount_amount'] = $request->discount_amount;
        $data['discount_percentage'] = $request->discount_percentage;
        $data['has_stock'] = $request->has_stock;
        $data['view_section'] = $request->view_section;
        $data['excerpts'] = $request->excerpts;
        $data['details'] = $request->details;
        $data['status'] = $request->status;

       // dd($data);
        //product photo
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $path = 'assets/images/product';
            $file_name = 'photo_'.rand(000000000,999999999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($path),$file_name);
            $data['photo'] = $path.'/'.$file_name;

            if(file_exists(public_path($checkProduct->photo))){
                unlink(public_path($checkProduct->photo));
            }
        }

        //multiple photo upload
        if($request->hasFile('multiple_photo')){
            //if has multiple photo first delete all old photo
            $allProductPhoto = Productphoto::where('product_id',$checkProduct->id)->get();
            if (count($allProductPhoto) > 0){
                DB::table('productphotos')
                    ->where('product_id',$checkProduct->id)
                    ->delete();

                foreach ($allProductPhoto as $photo){
                    if(file_exists(public_path($photo->photo))){
                        unlink(public_path($photo->photo));
                    }
                }
            }
            foreach ($request->multiple_photo as $img){
                $path = 'assets/images/product';
                $file_name = 'photo_'.rand(000000000,999999999).'.'.$img->getClientOriginalExtension();
                $img->move(public_path($path),$file_name);

                Productphoto::create([
                    'product_id' => $checkProduct->id,
                    'photo' => $path.'/'.$file_name,
                ]);
            }
        }   //Multiple Products end


        DB::table('products')
            ->where('id',$id)
            ->update($data);
        return redirect()->back()->with('success','Successfully Updated Product');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    \App\Models\Product  $product
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //Check authentication
        if (!Auth::user()->can('product.delete')){
            abort(403,'Unauthorized Action');
        }
        $checkProduct = Product::findOrFail($product->id);

        if (!is_null($product)){
            $product->delete();
        }

        return redirect()->back()->with('success','Product Deleted Successfully');

    }


    public function productPriceCheck($product_id)
    {
        if (!Auth::user()->can('accounts.create')) {
            abort(403, 'Unauthorized Action');
        }

        $product = Product::where('id', $product_id)->first();

        if ($product) {
            $data['product_price'] = $product->sale_price;
            $data['reward_point'] = $product->point;
            $data['product_name'] = Settings::unicodeName($product->name);
            $data['warranty'] = $product->warranty->warranty_name;
            $data['stock'] = Settings::productStock($product_id);
            return $data;
        } else {
            return 0;
        }

    }
}

