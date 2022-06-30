<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Reward;
use App\Models\Settings;
use App\Models\Stock;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */

    public function index()
    {
        //Check authentication
        if (!Auth::user()->can('order.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Order";
        $data['orders'] = Order::orderBy('created_at', 'DESC')->simplePaginate(100);
        return view('backend.order.index', $data);

    }

    public function deliveredOrder()
    {
        //Check authentication
        if (!Auth::user()->can('order.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Order";
        $data['orders'] = Order::where('status', Settings::STATUS_DELIVERED)->orderBy('created_at', 'DESC')->simplePaginate(100);
        return view('backend.order.index', $data);

    }


    public function newOrder()
    {
        //Check authentication
        if (!Auth::user()->can('order.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "New Order";
        $data['orders'] = Order::where('status', Settings::STATUS_PENDING)->orderBy('created_at', 'DESC')->simplePaginate(100);
        return view('backend.order.new_order', $data);
    }

    public function confirmedOrder()
    {
        //Check authentication
        if (!Auth::user()->can('order.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Confirmed Order";
        $data['orders'] = Order::where('status', Settings::STATUS_CONFIRMED)->orderBy('created_at', 'DESC')->simplePaginate(100);
        return view('backend.order.confirmed_order', $data);

    }

    public function shippingOrder()
    {
        //Check authentication
        if (!Auth::user()->can('order.all')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Shipping Order";
        $data['orders'] = Order::where('status', Settings::STATUS_SHIPPING)->orderBy('created_at', 'DESC')->simplePaginate(100);
        return view('backend.order.shipping_order', $data);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        //Check authentication
        if (!Auth::user()->can('order.create')) {
            abort(403, 'Unauthorized Action');
        }
        return redirect()->route('newOrder');
//        return view('backend.order.create');
    }

    public function statusCancelOrConfirmed(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('order.approved')) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'status' => ['required'],
            'id' => ['required'],
        ]);

        $data['status'] = $request->status;
        $data['id'] = $request->id;

        $hasPendingOrder = Order::where('id', $request->id)
            ->where('status', Settings::STATUS_PENDING)
            ->first();

        if ($hasPendingOrder) {
            DB::table('orders')
                ->where('id', $request->id)
                ->update($data);
            return redirect()->route('newOrder')->with('success', 'Successfully ' . $request->status . ' Order');
        } else {
            return redirect()->route('newOrder')->with('warning', 'Something went wrong, Try Again...');
        }


    }

    public function statusConfirmedToShipping(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('order.approved')) {
            abort(403, 'Unauthorized Action');
        }
        $request->validate([
            'id' => ['required'],
        ]);

        // Check Stock And go back - start
        $hasOrder = OrderDetails::where('order_id', $request->id)->get();
        $noStockFlag = 0;
        foreach ($hasOrder as $order) {
            $chkStock = Stock::where('product_id', $order->product_id)->where('stock', '>=', $order->quantity)->first();
            if ($chkStock) {
            } else {
                $noStockFlag++;
            }

            if ($noStockFlag > 0) {
                return redirect()->back()->with('warning', 'No Stock, Please Increase Stock First');
            }
            // Check Stock And go back - end


            DB::beginTransaction();
            try {
                $hasConfirmedOrder = Order::where('id', $request->id)
                    ->where('status', Settings::STATUS_CONFIRMED)
                    ->first();
                if ($hasConfirmedOrder) {
                    $orderDetails = OrderDetails::where('order_id', $request->id)->get();

                    foreach ($orderDetails as $order) {
                        $chkStock = Stock::where('product_id', $order->product_id)
                            ->where('stock', '>=', $order->quantity)
                            ->first();
                        if ($chkStock) {
                            $dataS['stock'] = $chkStock->stock - $order->quantity;  // old stock - order quantity
                            $dataS['sales'] = $chkStock->sales + $order->quantity; // old sales + order quantity

                            DB::table('stocks')
                                ->where('product_id', $order->product_id)
                                ->update($dataS);
                        } else {
                            return redirect()->route('dashboard')->with('warning', 'No Stock, Please Increase Stock First');
                        } //Stock end
                    }

                    //Reward Points Table
                    foreach ($orderDetails as $product) {
                        $hasProduct = Product::where('id',$product->product_id)->first();

                        $dataReward['order_id'] = $product->order_id;
                        $dataReward['product_id'] = $product->product_id;
                        $dataReward['customer_id'] = $hasConfirmedOrder->customer_id;
                        $dataReward['point'] = $hasProduct->point * $product->quantity;
                        $dataReward['purpose'] = Settings::REWARD_BUY_PRODUCT;
                        $dataReward['user_id'] = Auth::user()->id; //who create this !?

                        Reward::create($dataReward);
                    }// end foreach loop



                }

                $dataOrder['status'] = Settings::STATUS_SHIPPING;
                DB::table('orders')
                    ->where('id', $request->id)
                    ->update($dataOrder);


                DB::commit();
                return redirect()->route('confirmedOrder')->with('success', 'Successfully Status change to shipped and Stock Update');

            } catch (\Exception $exception) {
//            echo '<pre>';
            return $exception->getMessage();
                DB::rollBack();
                return back()->with('warning', 'Something error, please contact support.');
            }

        }

    }

    public function statusShippingToDelivered(Request $request)
    {
        //Check authentication
        if (!Auth::user()->can('order.approved')) {
            abort(403, 'Unauthorized Action');
        }
//        dd('delivered');

        $request->validate([
            'status' => ['required'],
            'id' => ['required'],
        ]);

        $data['status'] = $request->status;
        $data['id'] = $request->id;

        $hasPendingOrder = Order::where('id', $request->id)
            ->where('status', Settings::STATUS_PENDING)
            ->first();

        if ($hasPendingOrder) {
            DB::table('orders')
                ->where('id', $request->id)
                ->update($data);
            return redirect()->route('newOrder')->with('success', 'Successfully ' . $request->status . ' Order');
        } else {
            return redirect()->route('newOrder')->with('warning', 'Something went wrong, Try Again...');
        }


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
        if (!Auth::user()->can('order.create')) {
            abort(403, 'Unauthorized Action');
        }

        $request->validate([
            'oid' => ['nullable', 'string', 'min:3', 'max:255'],
            'customer_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'invoice_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'total_price' => ['nullable', 'string', 'min:3', 'max:255'],
            'total_discount' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_method_id' => ['nullable', 'string', 'min:3', 'max:255'],
        ], [
            'oid.required' => 'Please input oid',
            'customer_id.required' => 'Please input customer_id',
            'invoice_id.required' => 'Please input invoice_id',
            'total_price.required' => 'Please input total_price',
            'total_discount.required' => 'Please input total_discount',
            'payment_method_id.required' => 'Please input payment_method_id',
        ]);
        $data['oid'] = $request->oid;
        $data['customer_id'] = $request->customer_id;
        $data['invoice_id'] = $request->invoice_id;
        $data['total_price'] = $request->total_price;
        $data['total_discount'] = $request->total_discount;
        $data['payment_method_id'] = $request->payment_method_id;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //dd($data);

        //order photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/order';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;
        }
        $order = Order::create($data);
        return redirect()->back()->with('success', 'Successfully Create a new Order');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return  \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //Check authentication
        if (!Auth::user()->can('order.show')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = 'Order Details';
        $data['order'] = Order::findOrFail($order->id);
        $data['orderDetails'] = OrderDetails::where('order_id', $order->id)->get();

        return view('backend.order.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Order $order
     * @return  \Illuminate\Http\Response
     */
    public function edit(Order $order, $id)
    {
        //Check authentication
        if (!Auth::user()->can('order.update')) {
            abort(403, 'Unauthorized Action');
        }
        $data['pageTitle'] = "Order";
        $data['order'] = Order::findOrFail($id);
        return view('backend.order.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Check authentication
        if (!Auth::user()->can('order.update')) {
            abort(403, 'Unauthorized Action');
        }
        $checkOrder = Order::findOrFail($id);

        $request->validate([
            'order' => ['required', 'string', 'min:3', 'max:255', 'unique:orders,id,' . $request->id],
            'oid' => ['nullable', 'string', 'min:3', 'max:255'],
            'customer_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'invoice_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'total_price' => ['nullable', 'string', 'min:3', 'max:255'],
            'total_discount' => ['nullable', 'string', 'min:3', 'max:255'],
            'payment_method_id' => ['nullable', 'string', 'min:3', 'max:255'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ], [
            'oid.required' => 'Please input oid',
            'customer_id.required' => 'Please input customer_id',
            'invoice_id.required' => 'Please input invoice_id',
            'total_price.required' => 'Please input total_price',
            'total_discount.required' => 'Please input total_discount',
            'payment_method_id.required' => 'Please input payment_method_id',
        ]);
        $data['oid'] = $request->oid;
        $data['customer_id'] = $request->customer_id;
        $data['invoice_id'] = $request->invoice_id;
        $data['total_price'] = $request->total_price;
        $data['total_discount'] = $request->total_discount;
        $data['payment_method_id'] = $request->payment_method_id;
        $data['status'] = $request->status;
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))); // to get unique slug add...

        //order photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = 'frontend/images/order';
            $file_name = 'photo_' . rand(000000000, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $file_name);
            $data['photo'] = $path . '/' . $file_name;

            if (file_exists($checkOrder->photo)) {
                unlink($checkOrder->photo);
            }
        }

        DB::table('orders')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success', 'Successfully Updated Order');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //Check authentication
        if (!Auth::user()->can('order.delete')) {
            abort(403, 'Unauthorized Action');
        }
        $checkOrder = Order::findOrFail($order->id);

        if (!is_null($order)) {
            $order->delete();
        }

        return redirect()->back()->with('success', 'Order Deleted Successfully');

    }
}
