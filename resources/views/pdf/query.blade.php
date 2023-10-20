<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <style>
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    padding-top: 100px;
    background-image: url('./storage/logos/{{$query->user->logo}}');
    background-repeat: no-repeat;
    background-position: center center;  /* Center the logo */
    background-size: contain;  /* Resize the logo to fit the screen */
    position: relative;  /* Needed for absolute positioning of ::before pseudo-element */
}

body::before {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: white;
    opacity: 0.85;  /* Adjust opacity as needed */
    pointer-events: none;  /* Allows interaction with elements below */
    z-index: -1;  /* Place it behind the actual content */
}


        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px; /* Reduced height */
            background-color: #ffffff;
            border-bottom: 1px solid #eee;
            padding: 10px; /* Reduced padding */
            z-index: 1000;
        }

        .header img {
            width: 140px; /* Increased the logo size */
            margin-left: 20px; 
        }

        .container {
            width: 80%;
            margin: 2em auto;
        }

        h1, h2 {
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

        th, td {
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
    width: 100%;
    background-color: #2c3e50;  /* Dark blue color for the footer */
    padding: 20px 0;
    position: fixed;  /* This makes sure the footer stays at the bottom */
    bottom: 0;
    z-index: 999;  /* This ensures the footer stays on top of other content */
}

.footer-content {
    width: 100%;
    margin: 0 auto;
    color: #ecf0f1;  /* Light color for the text for contrast */
}

.footer-content p {
    text-align: center;
    margin: 10px 0;
}
    </style>
</head>

<body>
    <div class="header">
        <img src="./storage/logos/{{$query->user->logo}}" alt="Company Logo">
    </div>
    
    <div class="container">
        <h1>Quotation</h1>
        <h2>{{$query->user->company->name}}</h2>
        <h3>{{$query->created_at->format('d-m-Y')}}</h3>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($query->query_products as $query_product)
                @php
                $total = $total + ($query_product->product->price*$query_product->quantity);
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$query_product->product->name}}</td>
                    <td>{{$query_product->product->sku}}</td>
                    <td>{{$query_product->product->size}}</td>
                    <td>{{$query_product->quantity}}</td>
                    <td>{{$query_product->product->price}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                    <td>{{$total}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="footer">
    <div class="footer-content">
        <p><strong>Company Address:</strong>{{$query->user->company->name}}</p>
        <p><strong>Email:</strong> {{$query->user->email}}</p>
        <p><strong>Phone:</strong> {{$query->user->phone}}</p>
    </div>
</div>
</body>

</html>
