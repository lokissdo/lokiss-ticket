@extends('auth.master')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>   
    @endif
    <h1 class="d-flex justify-content-center mt-4 fw-bolder">Log in</h1>
    <div class="card-body px-4 py-5 px-md-5">
        <form>
            <!-- Email input -->
            <div class="form-outline mb-3">
                <label class="form-label" for="form3Example3">Email </label>
                <input type="email" id="form3Example3" class="form-control"  value="{{old('email')}}"/>
            </div>
            <!-- Password input -->
            <div class="form-outline ">
                <label class="form-label" for="form3Example4">Password</label>
                <input type="password" id="form3Example4" class="form-control"  value="{{old('password')}}" />
            </div>
            <div class="form-check text-left">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label for="flexCheckDefault">
                    Remember me
                </label>
            </div>
            {{-- forgot password and create password --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('register') }}" class="text-decoration-none">Forgot password ? </a>
                <a href="{{ route('register') }}" class="text-decoration-none">Create account</a>
            </div>

            <!-- Submit button -->
            <div class="form-outline mb-3 d-flex justify-content-center">
                <button type="submit" class=" btn btn-primary btn-block mx-auto">
                    <span class="btn-inner--text">Login</span>
                </button>
            </div>
            <!-- Register buttons -->
            <div class="text-center">
                <h5>or log in with:</h5>
                @include('components.icons')
            </div>
        </form>
    </div>
@endsection
