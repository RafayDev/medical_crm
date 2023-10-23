<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
    /* Global Styles */
    body {
        font-family: 'Arial', sans-serif;
        /* background-color: #f9f9f9; */
        color: #671b1d;
        margin: 0;
        padding: 0;
    }

    /* Add this to your styles */


    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 100px;
        /* Adjust as needed */
        border-bottom: 1px solid #ddd;
        padding: 0 50px;
        /* Adjust as needed */
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50px;
        /* Adjust as needed */
        border-top: 1px solid #ddd;
        text-align: center;
        padding: 15px 50px;
        /* Adjust as needed */
    }

    /* .container {
            margin: 100px 20px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        } */

    h1 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 8px 15px;
    }



    .logo img {
        /* bigger image */
        width: 200px;

    }


    .footer span {
        margin: 0 10px;
    }

    /* Invoice Table */
    th,
    td {
        border: 1px solid #ddd;
    }

    th {
        background-color: #f3f3f3;
        color: #671b1d;
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
        border :none;
    }

    .total-row {
        background-color: #f3f3f3;
    }

    .total-row td {
        font-weight: bold;
        color: #671b1d;
    }
    .container {
    padding-top: 120px; /* Height of the header + some spacing */
    padding-bottom: 70px; /* Height of the footer + some spacing */
    margin: 0 auto; /* Center the container if you want */
    max-width: 100%; /* Optional: Set a max width if you want */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Since you commented this out, you can uncomment now if you wish */
}
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <img src="./frontend/img/logo.png" alt="Company Logo">
            </div>
            <h1>Invoice</h1>
        </div>

        <!-- Invoice Info -->
        @php
        $total = 0;
        @endphp
        <table class="invoice-header">
            <tbody>
                <tr>
                    <td width="50%">
                        <strong>Company Name:</strong>
                        {{$invoice->user->company->name}}<br>

                        <strong>Client Name:</strong>
                        {{$invoice->user->name}}<br>

                        <strong>Email:</strong>
                        {{$invoice->user->email}}<br>

                        <strong>Phone:</strong>
                        {{$invoice->user->phone}}<br>

                        <strong>Address:</strong>
                        {{$invoice->user->company->address}}
                    </td>
                    <td width="50%" style="text-align: right;">
                        <strong>Date:</strong>
                        {{$invoice->created_at->format('d-m-Y')}}<br><br>

                        <strong>Invoice No:</strong>
                        AML-{{$invoice->id}}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Product Info -->
        <table style="text-align:center">
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
                @foreach($invoice->invoice_products as $invoice_product)
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

        <!-- Footer -->
        <div class="footer">
            <span><strong>Address:</strong> 123 Street, City, Country</span>
            <span><strong>Email:</strong> email@example.com</span>
            <span><strong>Phone:</strong> +1 (234) 567 890</span>
        </div>
    </div>
</body>

</html>