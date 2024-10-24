@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item">Login</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        @if (Session::has('success'))
        <div class="alert alert-success" style="font-family: 'Times New Roman', Times, serif; font-weight: bold ;">
            {{ Session::get('success') }}
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger" style="font-family: 'Times New Roman', Times, serif; font-weight: bold ;">
            {{ Session::get('error') }}
        </div>
        @endif
        <div class="login-form">
            <form action="{{ route('account.authenticate') }}" method="post">
                @csrf
                <h4 class="modal-title">Login to Your Account</h4>
                <div class="form-group">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Password" >
                    @error('password')
                        <p class="invalid-feedback">{{ $message }}</p><br>
                    @enderror <br>
                    <input type="checkbox" onclick="myFunction()">   <label style="font-variant-emoji:unicode;">Show Password</label>
                </div>
                <div class="form-group small">
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>
                <input type="submit" class="btn btn-dark btn-block btn-lg" value="Login">
            </form>
            <div class="text-center small">Don't have an account? <a href="{{ route('account.register') }}">Sign up</a></div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endsection