
@extends('lay.Admin')



@section('content')
<div class="container">
    <h4 class="m-0 text-dark">Orders</h4>
    <table style="width:90%" class="table">
        <tr>
            <th  scope="col">Order id</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">phone</th>
            <th scope="col">Date</th>
            <th scope="col">Payment</th>
            <th scope="col">Invoice</th>
        </tr>
        @foreach($products as $product)

        <tr>

            <td scope="row">{{$product['id']}}</td>
            <td>{{$product['name']}}</td>
            <td>{{$product['address']}}</td>
            <td>{{$product['phone']}}</td>
            <td>{{$product['date']}}</td>
            <td>{{$product['bkashnumber']}}<br>{{$product['txid']}}</td>
            <td><a href="/admin/order/{{$product['id']}}">Check</a></td>
        </tr>

        @endforeach
    </table>

    {{$products->links()}}
</div>
@endsection
