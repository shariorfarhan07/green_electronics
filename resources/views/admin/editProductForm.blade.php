
@extends('lay.Admin')



@section('content')

<div class="container" >
    <h4 class="m-0 text-dark">Edit Product Form</h4>
    <form action="{{url('/admin/updateproduct/'.$product->id)}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="product Name" value="{{$product->Name}}"required>
        </div>
        <div class="form-group">
            <label for="description">description</label>
            <textarea  class="form-control" name="description" id="description" placeholder="description" value="{{$product->description}}"required>{{$product->description}}</textarea>
        </div>
        <div class="form-group">
            <label for="description">small description</label>
            <textarea  class="form-control" name="sdescription" id="sdescription" placeholder="small description">{{$product->sdescription}}</textarea>
        </div>
        <div class="form-group">
            <label for="description">Data sheet</label>
            <textarea  class="form-control" name="datasheet" id="datasheet" placeholder="data description">{{$product->datasheet}}</textarea>
        </div>
        <div class="form-group">
            <label for="price">price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="price" value="{{$product->price}}"required>
        </div>
        <div class="form-group">
            <label for="stock">stock</label>
            <input type="text" class="form-control" name="stock" id="stock" placeholder="stock" value="{{$product->stock}}"required>
        </div>
        <div class="form-group">
            <label for="type1">small category</label>
            <input type="text" class="form-control" name="type1" id="type1" placeholder="type1" value="{{$product->type1}}">
        </div>
        <div class="form-group">
            <label for="type2">Big category</label>
            <input type="text" class="form-control" name="type2" id="type2" placeholder="type2" value="{{$product->type2}}">
        </div>
        <div class="form-group">
            <label for="type3">Brand</label>
            <input type="text" class="form-control" name="type3" id="type3" placeholder="type3" value="{{$product->type3}}">
        </div>
        <div class="form-group">
            <label for="slug">slug</label>
            <input type="text" class="form-control" name="slug" id="slug" placeholder="slug" value="{{$product->slug}}">
        </div>
        <button type="submit" name="submit" class="btn btn-default">submit</button>
    </form>




</div>


@endsection
