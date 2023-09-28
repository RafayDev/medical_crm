<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
</head>
<style>
.container {
    width: 100%;
    margin: 0 auto;
}

h1 {
    text-align: center;
}

.small {
    /* low line spacing  */
    line-height: 0.7;
}

.details {
    display: flex;
    justify-content: space-between;
}

.right {
    /* on the right on page */
    float: right;
}

.col {
    float: left;
    width: 33%;
    /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* 
h2 {
    text-align: center;
}

h3 {
    text-align: center;
} */
</style>
@php
$total = 0;
@endphp

<body>
    <div class="container">
        <h1>Invoice</h1>
        <div class="row">
            <div class="col">
                <p class="small">Client Name: {{$invoice->user->name}}</p>
                <p class="small">Company: {{$invoice->user->company->name}}</p>
            </div>
            <div class="col"></div>
            <div class="col">
                <p class="small">Invoice Date: {{$invoice->created_at->format('d-m-Y')}}</p>
                <p class="small">Invoice No: AML-{{$invoice->id}}</p>
            </div>

        </div>
        <table width="100%" border="1" style="text-align:center;margin-top: 20px;" cellspacing="0" cellpadding="2">
            <thead>
                <th>#</th>
                <th>Product Name</th>
                <th>Price Per Unit ($) </th>
                <th>Quantity</th>
                <th>Total Price ($)</th>
            </thead>
            <tbody>
                @foreach($invoice->invoice_products as $invoice_product)
                @php
                $total += $invoice_product->total_price;
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$invoice_product->product->name}}</td>
                    <td>{{$invoice_product->price_per_unit}}</td>
                    <td>{{$invoice_product->quantity}}</td>
                    <td>{{$invoice_product->total_price}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4"><strong>Total ($)</strong></td>
                    <td>{{$total}}</td>
                </tr>
            </tbody>
        </table>

    </div>
</body>

</html>