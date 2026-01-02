@extends('auth.layouts.app')
@section('content')
    <div class="text-center mb-4">
        <p class="mb-0">Please log in to your account</p>
    </div>
    <div class="form-body">        
        <form class="row g-3" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"placeholder="Enter username" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12">
                <label for="password" class="form-label">Password</label>
                <div class="input-group" id="show_hide_password">
                    <input id="password" type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" required autocomplete="current-password">
                    <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                </div>
            </div>
            <div class="col-md-6 text-end">	<a href="{{ route('password.request') }}">Forgot Password ?</a>
            </div>
            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
            <div class="col-12">
                <div class="text-center ">
                    <p class="mb-0">Don't have an account yet? <a href="{{ route('register') }}">Register here</a>
                    </p>
                </div>
            </div>
        </form>
    </div>					
@endsection