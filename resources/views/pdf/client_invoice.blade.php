<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Invoice</title>
    <style>
    @page {
        margin: 0px;
        padding: 0px;
    }

    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        padding-top: 100px;
        position: relative;
    }

    .page-background {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('./storage/logos/{{$invoice->user->logo}}');
        background-repeat: no-repeat;
        background-position: center center;
        background-size: contain;
        z-index: -2;
    }

    .opacity-layer {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: white;
        opacity: 0.85;
        pointer-events: none;
        z-index: -1;
    }

    .header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 80px;
        background-color: #ffffff;
        border-bottom: 1px solid #eee;
        padding: 10px;
        z-index: 1000;
    }

    .header img {
        width: 140px;
        margin-left: 20px;
    }

    .container {
        width: 95%;
        height: 70%
        margin: 2em auto;
    }

    h1,
    h2 {
        margin: 0.5em 0;
    }

    h1 {
        text-align: center;
        font-size: 24px;
    }

    h2 {
        text-align: center;
        font-size: 20px;
        color: #666;
    }

    h3 {
        text-align: right;
        font-size: 16px;
        color: #999;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2em;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 0.5em 1em;
    }

    th {
        background-color: #f5f5f5;
    }

    td {
        text-align: center;
    }

    .footer {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #2c3e50;
        padding: 20px 0;
        z-index: 999;
    }
    .footer-content {
        width: 100%;
        margin: 0 auto;
        color: #ecf0f1;
    }

    .footer-content p {
        text-align: center;
        margin: 10px 0;
    }
    .invoice-header {
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .invoice-header td {
        vertical-align: top;
        padding: 10px;
        font-size: 14px;
        color: #666;
        border: none;
        text align: left;
    }
    </style>
</head>

<body>
    <div class="page-background"></div>
    <div class="opacity-layer"></div>

    <div class="header">
        <img src="./storage/logos/{{$invoice->user->logo}}" alt="Company Logo">
    </div>

    <div class="container">
        <h1>Invoice</h1>
    </div>
    <table class="invoice-header">
            <tbody>
                <tr>
                    <td width="50%">
                        <strong>Company Name:</strong>
                        {{$invoice->company}}<br>

                        <strong>Client Name:</strong>
                        {{$invoice->name}}<br>

                        <strong>Email:</strong>
                        {{$invoice->email}}<br>

                        <strong>Phone:</strong>
                        {{$invoice->phone}}<br>

                        <strong>Address:</strong>
                        {{$invoice->address}}
                    </td>
                    <td width="50%" style="text-align: right;">
                        <strong>Date:</strong>
                        {{$invoice->created_at->format('d-m-Y')}}<br>

                        <strong>Invoice No:</strong>
                        {{$invoice->user->company->quotation_series}}-{{$invoice->id}}
                    </td>
                </tr>
            </tbody>
        </table>
    @php
    $total = 0;
    @endphp
    <table style="text-align:center; font-size:14px; ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Size</th>
                    <th>Price Per Unit ($)</th>
                    <th>Quantity</th>
                    <th>Total Price ($)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->client_invoice_products as $invoice_product)
                @php
                $total += $invoice_product->total_price;
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$invoice_product->product->name}}</td>
                    <td>{{$invoice_product->product->sku}}</td>
                    <td>{{$invoice_product->product->size}}</td>
                    <td>{{$invoice_product->price_per_unit}} $</td>
                    <td>{{$invoice_product->quantity}}</td>
                    <td>{{$invoice_product->total_price}} $</td>
                </tr>
                @endforeach
                    <tr class="total-row">
                        <td colspan="6">Sales Tax ($)</td>
                        <td>{{$invoice->sales_tax}} $</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="6">Freight Charges($)</td>
                        <td>{{$invoice->freight_charges}} $</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="6">Total ($)</td>
                        <td>{{$invoice->sales_tax+$invoice->freight_charges+$total}} $</td>
                    </tr>
            </tbody>
        </table>
    <div class="stamp">
        @if($invoice->user->company->stamp)
        <img src="./storage/stamps/{{$invoice->user->company->stamp}}" alt="Company Stamp" 
        style="width: 100px; height: 100px; margin-left: 10%; margin-top: 10px; margin-bottom: 10px;"
        >
        @endif
    </div>
    <div class="footer">
        <div class="footer-content">
            <p><strong>Company Address:</strong>{{$invoice->user->company->address}}</p>
            <p><strong>Email:</strong> {{$invoice->user->email}}</p>
            <p><strong>Phone:</strong> {{$invoice->user->phone}}</p>
            <p style="font-size:12px;">System Generated</p>
        </div>
    </div>
</body>

</html>