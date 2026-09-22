@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Personal Information') }}</div>

                <div class="card-body">

                    <p>Name: {!!Auth::user()->name!!} <br>Email: {!!Auth::user()->email!!}

                    </p>
                    @if($userdata->isAdmin())
                    <a href="{{url('admin')}}">take me to admin panel</a>
                    @else
                    <a href="{{route('homepage')}}">Continue Shopping!!</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
