@extends('layout')

@section('title', 'Contact us')

@section('content')
    <h1>Contact us</h1>

    @if( ! session()->has('message'))
        <form action="{{ route('contact.store') }}" method="post">
            <div class="form-group">
                <labe for="name">Name:</labe>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                <div>{{ $errors->first('name') }}</div>
            </div>

            <div class="form-group">
                <label for="email">E-mail: </label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                <div>{{ $errors->first('email') }}</div>
            </div>
            <div class="form-group">
                <label for="message">Message: </label>
                <textarea name="message" id="message" cols="30" rows="10" value="{{ old('email') }}"
                          class="form-control"></textarea>
                <div>{{ $errors->first('message') }}</div>
            </div>

            @csrf

            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    @endif
@endsection
