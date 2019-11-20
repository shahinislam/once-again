@extends('layouts.app')

@section('title', 'Add new customer')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Add new customer</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('customers.store') }}" enctype="multipart/form-data" method="post">
                @include('customers.form')

                <button type="submit" class="btn btn-primary">Add Customer</button>
            </form>
        </div>
    </div>

@endsection
