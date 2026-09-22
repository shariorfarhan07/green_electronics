@extends('lay.admin')
@section('content')
<div class="table-responsive">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <li>
                {!!print_r($errors->all())!!}
            </li>
        </ul>
    </div>
</div>
@endif


<div class="container">
    <h4 class="m-0 text-dark">Edit Product Image Form</h4>
    <h3>Current Image</h3>
    <div><img src="<?php echo Storage::url('product_images/'.$product['image3']);?>" width="100" height="100" style="max-height: 220px">

        <form action="{{url('/admin/updateproductimageform3/'.$product->id)}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="image">Upload 2st image</label>
                <input type="file" class="" name="image" id="image" value="{{$product->image3}}"required>
            </div>

            <button type="submit" name="submit" class="btn btn-default">Submit</button>
        </form>














    </div>
    @endsection
