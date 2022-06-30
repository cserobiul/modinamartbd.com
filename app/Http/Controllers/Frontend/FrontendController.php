<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Productphoto;
use App\Models\Purchase;
use App\Models\Reward;
use App\Models\Settings;
use App\Models\Slider;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class FrontendController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data['sliders'] = Slider::where('status', 'active')->orderBy('order', 'ASC')->limit(5)->get();


        $data['products'] = Product::where('status', 'active')
            ->whereIn('category_id', [1, 2, 3, 4])
            ->orderBy('created_at', 'DESC')
            ->limit(30)
            ->get();

        $data['NEW_ARRIVAL'] = Product::where('status', 'active')
            ->where('view_section', 'NEW_ARRIVAL')
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();


        $data['BEST_SELLER'] = Product::where('status', 'active')
            ->where('view_section', 'BEST_SELLER')
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();
        $data['MOST_POPULAR'] = Product::where('status', 'active')
            ->where('view_section', 'MOST_POPULAR')
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();
        $data['FLASH_SELL'] = Product::where('status', 'active')
            ->where('view_section', 'FLASH_SELL')
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();
        $data['JUST_FOR_YOU'] = Product::where('status', 'active')
            ->where('view_section', 'JUST_FOR_YOU')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();
        $data['SPECIAL_OFFER'] = Product::where('status', 'active')
            ->where('view_section', 'JUST_FOR_YOU')
            ->orderBy('created_at', 'DESC')
            ->limit(2)
            ->get();

        return view('frontend.home.index', $data);
    }

    public function __construct()
    {

    }

    public function home()
    {

        $data['sliders'] = Slider::where('status', 'active')->orderBy('order', 'ASC')->limit(5)->get();

//        $data['foodCategories'] = Product::where('business_category', 'Food')->distinct('category_id')->limit(10)->get();
//        $data['fashionCategories'] = Product::where('business_category', 'Fashion')->distinct('category_id')->limit(10)->get();
//        $data['libraryCategories'] = Product::where('business_category', 'Library')->distinct('category_id')->limit(10)->get();
//
//        $data['foods'] = Product::where('business_category', 'Food')->orderBy('created_at','DESC')->limit(5)->get();
//        $data['fashions'] = Product::where('business_category', 'Fashion')->orderBy('created_at','DESC')->limit(5)->get();
//        $data['libraries'] = Product::where('business_category', 'Library')->orderBy('created_at','DESC')->limit(5)->get();

        //  dd($data['foodCategories']);


        //dd($data);
//        $data['distinct_categories'] = Product::select('category_id')->distinct()->limit(4)->get();
//        $data['browse_categories'] = Category::whereNull('parent_id')
//            ->with(['parentCategory'])
//            ->orderBy('created_at', 'DESC')
//            ->limit(10)
//            ->get();

        $data['products'] = Product::where('status', 'active')
            ->whereIn('category_id', [1, 2, 3, 4])
            ->orderBy('created_at', 'DESC')
            ->limit(30)
            ->get();

        $data['NEW_ARRIVAL'] = Product::where('status', 'active')
            ->where('view_section', 'NEW_ARRIVAL')
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();


        $data['BEST_SELLER'] = Product::where('status', 'active')
            ->where('view_section', 'BEST_SELLER')
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();
        $data['MOST_POPULAR'] = Product::where('status', 'active')
            ->where('view_section', 'MOST_POPULAR')
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();
        $data['FLASH_SELL'] = Product::where('status', 'active')
            ->where('view_section', 'FLASH_SELL')
            ->orderBy('created_at', 'DESC')
            ->limit(15)
            ->get();
        $data['JUST_FOR_YOU'] = Product::where('status', 'active')
            ->where('view_section', 'JUST_FOR_YOU')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();
        $data['SPECIAL_OFFER'] = Product::where('status', 'active')
            ->where('view_section', 'JUST_FOR_YOU')
            ->orderBy('created_at', 'DESC')
            ->limit(2)
            ->get();

        return view('frontend.home.index-2', $data);

    }

    public function productDetailsSlug($slug)
    {

        $data['product'] = Product::where('slug', $slug)->first();
        $data['productPhotos'] = Productphoto::where('product_id', $data['product']->id)->limit(3)->get();


        //Check Stock
        $checkStock = $data['product']->has_stock;
        if ($checkStock == 1) {
            $currentStock = Stock::where('product_id', $data['product']->id)->whereNotNull('stock')->first();
            if ($currentStock) {
                $data['stock'] = Stock::where('product_id', $data['product']->id)->whereNotNull('stock')->orderBy('id', 'ASC')->get();
            } else {
                $data['stock'] = [];
            }
        } else {
            $data['stock'] = [];
        }

        $data['related_products'] = Product::where('category_id', $data['product']->category_id)->limit(10)->get();
        return view('frontend.product.show', $data);
    }

    public function categoryPage()
    {
        $data['products'] = Product::orderBy('category_id', 'ASC')->paginate(9);
        return view('frontend.product.category', $data);
    }

    public function categoryDetailsSlug($slug)
    {
        $data['category'] = Category::where('slug', $slug)->first();
        $data['products'] = Product::where('category_id', $data['category']->id)->orderBy('created_at', 'DESC')->paginate(9);
        return view('frontend.product.single-category', $data);
    }


    public function brandPage()
    {
        $data['products'] = Product::orderBy('brand_id', 'ASC')->paginate(9);
        return view('frontend.product.brand', $data);
    }

    public function brandDetailsSlug($slug)
    {
        $data['brand'] = Brand::where('slug', $slug)->first();
        $data['products'] = Product::where('brand_id', $data['brand']->id)->orderBy('created_at', 'DESC')->paginate(9);
        return view('frontend.product.single-brand', $data);
    }

    public function aboutUs()
    {
        return 'about us';
    }

    public function contactUs()
    {
        return 'contact us';
    }

    public function shopPage()
    {
        $data['products'] = Product::orderBy('created_at', 'DESC')->paginate(20);
        return view('frontend.product.shop', $data);
    }

    public function searchPage(Request $request)
    {
        $data['keyword'] = $request->keyword;
        $data['products'] = Product::where('name', 'LIKE', '%' . $request->keyword . '%')
            ->orWhere('slug', 'LIKE', '%' . $request->keyword . '%')
            ->orWhere('details', 'LIKE', '%' . $request->keyword . '%')
            ->paginate(9);


        return view('frontend.product.search', $data);
    }

    public function customerSingleOrderDetails($cusId, $oId)
    {
        if (!Auth::user()->can('customer.self')) {
            abort(403, 'Unauthorized Action');
        }
        $hasCustomer = Customer::where('id', $cusId)->first();
        $hasOrder = Order::where('id', $oId)->first();

        if ($hasCustomer) {
            if ($hasOrder) {
                $data['orders'] = OrderDetails::with('product')->where('order_id', $oId)->get();
                return $data;
            }
        } else {
            return response()->json(['response' => false]);
        }
    }

    public function productQuickView($slug)
    {

        $data['product'] = Product::where('slug', $slug)->first();
        $data['productPhotos'] = Productphoto::where('product_id', $data['product']->id)->limit(3)->get();

        return $data;
    }

    public function dashboard()
    {
        if (Auth::user()->can('settings.all')) {

            $data['newOrders'] = count(Order::where('status', Settings::STATUS_PENDING)->get());
            $data['confirmedOrders'] = count(Order::where('status', Settings::STATUS_CONFIRMED)->get());
            $data['shippingOrders'] = count(Order::where('status', Settings::STATUS_SHIPPING)->get());
            $data['deliveredOrders'] = count(Order::where('status', Settings::STATUS_DELIVERED)->get());

            $data['productsNo'] = count(Product::all());
            $data['purchaseNo'] = count(Purchase::all());

            $data['customerNo'] = count(Customer::all());
            $data['supplierNo'] = count(Supplier::all());


            // dd($data);

            return view('backend.dashboard.index', $data);
        } elseif (Auth::user()->can('customer.self')) {

            $customerId = Customer::where('user_id',Auth::user()->id)->first();

            $data['points'] = Reward::where('customer_id', $customerId->id)->paginate(100);
            $data['orders'] = Order::where('user_id', Auth::user()->id)->paginate(100);
            $data['customer'] = Customer::where('user_id', Auth::user()->id)->first();
            return view('frontend.dashboard.dashboard', $data);
        } else {
            abort(403, 'Unauthorized Action');
        }

    }

    public function customerProfileUpdate(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('customer.self')) {
            abort(403, 'Unauthorized Action');
        }

        //Validation User Data
        $userId = Auth::user()->id;
        $oldData = User::where('id', $userId)
            ->where('status', 'active')
            ->first();
        if (!$oldData) {
            return redirect()->route('dashboard');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:50'],
//            'shop_name' => ['required', 'string', 'min:5', 'max:50'],
            'address' => ['required', 'string', 'min:3', 'max:50'],
            'phone' => ['required', 'string', 'min:11', 'max:11'],
//            'email' => ['required', 'string', 'min:5', 'max:255','unique:users,id',$userId],
            'password' => ['nullable', 'min:6', 'max:20', 'confirmed'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg', 'max:256',/*'dimensions:min_width=500,min_height=600'*/],
        ], [
            'name.required' => 'Please give your full name'
        ]);
        if ($validator->passes()) {
        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        DB::beginTransaction();
        try {
            $data['name'] = $request->name;
            $data['phone'] = $request->phone;
            $data['username'] = $request->phone;

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
                $data['text_password'] = $request->password;
            }

            //User table Update
            DB::table('users')->where('id', $userId)->update($data);

            $customerData['customer_name'] = $request->name;
            $customerData['address'] = $request->address;
            $customerData['phone'] = $request->phone;

            //Customer Update
            DB::table('customers')->where('user_id', $userId)->update($customerData);

            DB::commit();
            return response()->json(['success' => 'Successfully Account Details Updated']);
        } catch (\Exception $exception) {
//            return $exception->getMessage();
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong, try again.']);
        }

    }

    public function loginRegisterPopUp()
    {
        return view('frontend.layouts.login');
    }


    public function allClearNOptimized()
    {
        Artisan::call('route:clear');
        Artisan::call('optimize');
//        return 'c r o done';
        return redirect()->route('home');
    }


}
