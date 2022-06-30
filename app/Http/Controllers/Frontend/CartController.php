<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Reward;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class CartController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function cart()
    {
        $data['settings'] = Settings::where('id', 1)->first();
        return view('frontend.cart.cart', $data);
    }

    public function checkoutPage(Request $request)
    {
        $data['settings'] = Settings::where('id', 1)->first();

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $data['customer'] = Customer::where('user_id', $userId)->first();

            return view('frontend.cart.login_register', $data);
        } else {
            $data['customer'] = '';
            return view('frontend.cart.login_register', $data);
        }
    }

    public function checkoutPageProcess(Request $request)
    {

        $chkOldCustomer = Customer::where('phone', $request->phone)->first();

        if ($chkOldCustomer) {
        } else {
            //Validation Data
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:5', 'max:50'],
                'email' => ['required', 'string', 'min:10', 'max:50', 'unique:users'],
                'phone' => ['required', 'min:11', 'max:11', 'unique:users'],
                'order_note' => ['nullable', 'min:5', 'max:1000'],
            ], [
                'phone.min' => 'Enter valid phone no',
                'phone.max' => 'Enter valid phone no',
                'phone.unique' => 'Phone no already exist',
            ]);
            if ($validator->passes()) {
            } else {
                return response()->json(['error' => $validator->errors()->all()]);
            }
        }

        DB::beginTransaction();
        try {

            if ($chkOldCustomer) {   //If old user then get user and customer info from database
                $user = User::where('phone', $request->phone)->first();
                $customer = $chkOldCustomer;
            } else { //If customer not found in database create new user and customer
                // data process for user table
                $dataUser['uid'] = uniqid();
                $dataUser['name'] = $request->name;
                $dataUser['phone'] = $request->phone;
                $dataUser['username'] = $request->phone;
                $dataUser['email'] = $request->email;
                $dataUser['status'] = Settings::STATUS_ACTIVE;
                if ($request->password == null) {
                    $dataUser['password'] = bcrypt($request->phone);
                    $dataUser['text_password'] = $request->phone;
                } else {
                    $dataUser['password'] = bcrypt($request->password);
                    $dataUser['text_password'] = $request->password;
                }

                //Create User
                $user = User::create($dataUser);
                //Assign Customer Role
                $user->assignRole('customer');


                //Data process for customer table
                $dataCustomer['user_id'] = $user->id;
                $dataCustomer['customer_name'] = $request->name;
                $dataCustomer['phone'] = $request->phone;
                $dataCustomer['email'] = $request->email;
                $dataCustomer['address'] = $request->address;

                $customer = Customer::create($dataCustomer);

                //If new customer than do this
                $dataNewCustomerReward['customer_id'] = $customer->id;
                $dataNewCustomerReward['point'] = 500;
                $dataNewCustomerReward['type'] = 0;
                $dataNewCustomerReward['purpose'] = Settings::REWARD_BONUS;
                $dataNewCustomerReward['user_id'] = $user->id;

                Reward::create($dataNewCustomerReward);
            }

            //Data process for order
            $newOID = Settings::oidGenerator();
            $newINV = Settings::invoiceGenerator();

            $dataOrder['oid'] = $newOID;
            $dataOrder['customer_id'] = $customer->id;
            $dataOrder['invoice_id'] = $newINV;
            $dataOrder['user_id'] = $user->id;
            $dataOrder['total_price'] = $request->totalPrice;
            $dataOrder['total_discount'] = $request->totalDiscount;
            $dataOrder['payment_method_id'] = 1;
            $dataOrder['order_note'] = $request->order_note;
            $dataOrder['shipping_address'] = $request->address;

            $order = Order::create($dataOrder);

            //Data process for order details

            $cartData = $request->cartData;

            foreach ($cartData as $product) {
                $dataOrderDetails['order_id'] = $order->id;
                $dataOrderDetails['product_id'] = $product['productId'];
                $dataOrderDetails['quantity'] = $product['cusQty'];
                $dataOrderDetails['price'] = $product['cusPrice'];
                $dataOrderDetails['discount'] = $product['cusDiscount'];
                OrderDetails::create($dataOrderDetails);
            }

            DB::commit();

            return response()->json(['response' => true, 'orderId' => $newOID]);

        } catch (\Exception $exception) {
            DB::rollBack();
            echo '<pre>';
            return $exception->getMessage();
            return json_encode(['response' => false]);
        }
    }


    public function loginRegister()
    {
        $data['settings'] = Settings::where('id', 1)->first();
        return view('frontend.cart.login_register', $data);
    }
}
