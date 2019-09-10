@extends('layouts.master')

@section('title')
    Welcome to Laravel!
@endsection


@section('content')
    <br><br>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('register') }}" method="post">
              <div class="form-group">
                <label for="email">Your Email address</label>
                <input type="email" class="form-control" name="email">
              </div>
              <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" class="form-control" name="name">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password">
              </div>
              <button type="submit" class="btn btn-primary">Sign Up</button>
              <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>

        <div class="col-md-6">
            <form action="{{ route('login') }}" method="post">
              <div class="form-group">
                <label for="email">Your Email address</label>
                <input type="email" class="form-control" name="email">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password">
              </div>
              <button type="submit" class="btn btn-primary">Log In</button>
              <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>
@endsection