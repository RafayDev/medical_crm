<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query</title>
</head>
<style>
.container {
    width: 100%;
    margin: 0 auto;
}

h1 {
    text-align: center;
}

h2 {
    text-align: center;
}

h3 {
    text-align: center;
}
</style>
@php
$total = 0;
@endphp
<body>
    <div class="container">
        <h1>Query</h1>
        <h2>{{$query->user->company->name}}</h2>
        <h3>{{$query->created_at->format('d-m-Y')}}</h3>
        <table width="100%" border="1" style="text-align:center;margin-top: 20px;" cellspacing="0" cellpadding="2">
            <thead>
                <th>#</th>
                <th>Product Name</th>
                <th>Quantity</th>
            </thead>
            <tbody>
                @foreach($query->query_products as $query_product)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$query_product->product->name}}</td>
                    <td>{{$query_product->quantity}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>
</body>

</html>