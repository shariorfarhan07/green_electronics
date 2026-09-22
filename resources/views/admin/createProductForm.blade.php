
@extends('lay.Admin')



@section('content')



<div class="container" >
    <form action="{{route('adminsendcreateproductform')}}" method="post"  enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="description">Upload image</label>
            <input type="file" class="" name="image" id="image" required>

        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="product Name" required>
        </div>
        <div class="form-group">
            <label for="description">description</label>
            <textarea  class="form-control" name="description" id="description" placeholder="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="description">small description</label>
            <textarea  class="form-control" name="sdescription" id="sdescription" placeholder="small description"></textarea>
        </div>
        <div class="form-group">
            <label for="description">Data sheet</label>
            <textarea  class="form-control" name="datasheet" id="datasheet" placeholder="data description"></textarea>
        </div>
        <div class="form-group">
            <label for="price">price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="price" required>
        </div>
        <div class="form-group">
            <label for="stock">stock</label>
            <input type="text" class="form-control" name="stock" id="stock" placeholder="stock" required>
        </div>
        <div class="form-group">
            <label for="type1">Small Category</label>
            <input type="text" class="form-control" name="type1" id="type1" placeholder="type1"  value="type1">
        </div>
        <div class="form-group">
            <label for="type2">Big category</label>
            <input type="text" class="form-control" name="type2" id="type2" placeholder="type2" value="type2">
        </div>
        <div class="form-group">
            <label for="type3">Brand</label>
            <input type="text" class="form-control" name="type3" id="type3" placeholder="type3" value="type3">
        </div>
        <div class="form-group">
            <label for="slug">slug</label>
            <input type="text" class="form-control" name="slug" id="slug" placeholder="slug" value="slug">
        </div>
        <div class="form-group">
        <label for="homepage" >Add your homepage:</label>
        <input type="url" id="link" name="link" placeholder="youtube link" >
        </div>
        <button type="submit" name="submit" class="btn btn-default">submit</button>
    </form>




</div>











@endsection
