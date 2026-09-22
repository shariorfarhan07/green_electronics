
@extends('lay.Admin')



@section('content')
<div class="container">
<h4 class="m-0 text-dark">Hi welcome to admin panel of ElectronicsBagBd.com</h4>
<table style="width:90%" class="table">
    <tr>
        <th  scope="col">ID</th>
        <th scope="col">Image</th>
        <th scope="col">Name</th>
        <th scope="col">description</th>
        <th scope="col">type</th>
        <th scope="col">price</th>
        <th scope="col">Edit all images</th>
        <th scope="col">Edit details</th>
        <th scope="col">Delete</th>
    </tr>
@foreach($products as $product)
<tr>
    <td  scope="row">{{$product['id']}}</td>
    <td><img src="<?php echo Storage::url('product_images/'.$product['image']);?>" width="100" height="100" style="220px"></td>
    <td>{{$product['Name']}}</td>
    <td>{{$product['description']}}</td>
    <td>{{$product['type3']}}</td>
    <td>{{$product['price']}}</td>
    <td>
        <a href="{{route('editProductImageForm',$product['id'])}}" class="btn btn-primary">1</a>
        <a href="{{route('editProductImageForm1',$product['id'])}}" class="btn btn-primary">2</a>
        <a href="{{route('editProductImageForm2',$product['id'])}}" class="btn btn-primary">3</a>
        <a href="{{route('editProductImageForm3',$product['id'])}}" class="btn btn-primary">4</a>
    </td>
    <td><a href="{{route('editProductForm',$product['id'])}}" class="btn btn-primary">Edit</td>
    <td><a href="{{route('deleteproduct',$product['id'])}}" class="btn btn-warning">Delete</td>
</tr>
@endforeach
</table>

{{$products->links()}}
</div>
@endsection
