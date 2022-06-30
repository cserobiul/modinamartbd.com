<style>
    body{
        font-family: "Times New Roman";
    }
    .page-break {
        page-break-after: always;
    }
    .border_bottom th { border-bottom: 1px solid #000000 !important; line-height: 1.5 !important;}

</style>

<table style="width: 100%">
    <tr style="width: 50%">
        <th style="text-align: left !important;">
            <img src="assets/images/image2vector.svg" style="width: 180px !important; height: 50px !important;" alt="">
        </th>
        <th style="text-align: right">
            Order # {{ $order->oid }} <br>
            Date: {{ date('d M Y',strtotime($order->created_at)) }}
        </th>
    </tr>
</table>
<br><br>
<table style="width: 100%">
     <tr>
        <th style="text-align: left !important;">
          Billed To: <br>
            {{ $customer->customer_name }} <br>
            {{ $customer->address }}, <br>
            {{ $customer->district }} <br>
            {{ $customer->phone }}

        </th>
         <th style="text-align: right !important;">
            Shipped To: <br>
            {{ $customer->customer_name }} <br>
            {{ $customer->address }}, <br>
            {{ $customer->district }} <br>
            {{ $customer->phone }}

        </th>
    </tr>

</table>
<hr>
<h2>Order Summary</h2>
<table style="text-align: center">
    <tr class="border_bottom">
        <th style="text-align: left !important;">
            Sl.
        </th>
        <th style="text-align: center !important;">
            Image
        </th>
        <th style="text-align: left !important; width: 380px !important;">
            Product
        </th>
        <th style="text-align: center !important; width: 40px !important;">
            Qty
        </th>
        <th style="text-align: center !important; width: 90px !important;">
            MRP
        </th>
        <th style="text-align: center !important; width:100px !important;">
            Amount
        </th>
    </tr>
    @foreach($orderDetails as $key => $product)
    <tr class="border_bottom">
        <th style="text-align: left !important;">
            {{ $key+1 }}
        </th>
        <th style="text-align: left !important;">
            <img src="{{ $product->product->photo }}"  style="width: 70px !important; height: 70px !important;" alt="">
        </th>
        <th style="text-align: left !important; margin-bottom: 5px">
            {{ $product->product->name }}
        </th>
        <th style="text-align: center !important;">
            {{ $product->quantity }}
        </th>
        <th style="text-align: center !important;">
            {{ $product->price }}
        </th>
        <th style="text-align: center !important;">
            {{ $product->quantity * $product->price }}
        </th>
    </tr>
    @endforeach
    <tr>
        <th colspan="6">&nbsp;&nbsp;&nbsp;&nbsp; </th>
    </tr>
    <tr>
        <th colspan="5" style="text-align: right !important;">
            Sub Total
        </th>
        <th style="text-align: center !important;">
           {{ $order->total_price + $order->total_discount }}Tk
        </th>
    </tr>
    <tr>
        <th colspan="5" style="text-align: right !important;">
            Discount
        </th>
        <th style="text-align: center !important;">
            {{ $order->total_discount }}Tk
        </th>
    </tr>
    <tr>
        <th colspan="5" style="text-align: right !important;">
            Total
        </th>
        <th style="text-align: center !important;">
            {{ $order->total_price }}Tk
        </th>
    </tr>
</table>


<table style="width: 100%" cellpadding="5">
    <tr style="width: 50%">
        <th style="text-align: left !important;">
          Order Note: <br>
          {{ $order->order_note }}

        </th>
    </tr>
</table>
<hr>
<strong>
    This Invoice is generate by Computer <br>
    BDWholesaler
</strong>
