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
            Invoice # {{ $sale->invoice_no }} <br>
            Date: {{ date('d M Y',strtotime($sale->created_at)) }}
        </th>
    </tr>
</table>
<br><br>
<table style="width: 100%">
     <tr>
        <th style="text-align: left !important;">
          Billed To: <br>
            {{ ucwords($buyer->name) }} <br>
            {{ ucfirst($buyer->address) }}, <br>
            {{ $buyer->phone }}

        </th>
         <th style="text-align: right !important;">
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
        <th style="text-align: center !important; width: 380px !important;">
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
    @foreach($saleDetails as $key => $product)
    <tr class="border_bottom">
        <th style="text-align: left !important;">
            {{ $key+1 }}
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
        <th colspan="4">&nbsp;&nbsp;&nbsp;&nbsp; </th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: right !important;">
            Sub Total
        </th>
        <th style="text-align: center !important;">
           {{ $sale->total_price + $sale->total_discount + $sale->special_discount  }}Tk
        </th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: right !important;">
            Discount
        </th>
        <th style="text-align: center !important;">
            {{ $sale->special_discount ? $sale->special_discount.' Tk' : '0' }}
        </th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: right !important;">
            Net Total
        </th>
        <th style="text-align: center !important;">
            {{ $sale->total_price }}Tk
        </th>
    </tr>
</table>

<br>
<strong>Note: You obtain {{ $sale->total_point }} points</strong>
<br><br>
<hr>
<strong>
    This is auto generated Invoice <br>
    {{ config('app.name') }}
</strong>
