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
    line-height: 1;
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
                <table>
                    <tbody>
                        <tr>
                            <td >Company Name: </td>
                            <td>{{$invoice->user->company->name}}</td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >Date: </td>
                            <td>{{$invoice->created_at->format('d-m-Y')}}</td>
                        </tr>
                        <tr>
                            <td >Client Name: </td>
                            <td>{{$invoice->user->name}}</td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td >&nbsp; </td>
                            <td>Invoice No: </td>
                            <td>AML-{{$invoice->id}}</td>
                        </tr>
                        <tr>
                            <td >Email: </td>
                            <td>{{$invoice->user->email}}</td>
                        </tr>
                        <tr>
                            <td >Phone: </td>
                            <td>{{$invoice->user->phone}}</td>
                        </tr>
                        <tr> 
                            <td >Address: </td>
                            <td>{{$invoice->user->company->address}}</td>
                        </tr>
                    </tbody>
                </table>
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
                    <td>{{$invoice_product->price_per_unit}} $</td>
                    <td>{{$invoice_product->quantity}}</td>
                    <td>{{$invoice_product->total_price}} $</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4"><strong>Sales Tax ($)</strong></td>
                    <td><strong>{{$invoice->sales_tax}} $</strong></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Freight Charges($)</strong></td>
                    <td><strong>{{$invoice->freight_charges}} $</strong></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Total ($)</strong></td>
                    <td><strong>{{$invoice->sales_tax+$invoice->freight_charges+$total}} $</strong></td>
                </tr>
            </tbody>
        </table>

    </div>
</body>

</html>