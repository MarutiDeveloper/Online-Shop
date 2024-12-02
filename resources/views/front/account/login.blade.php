<!-- <html>Login with Google</html> -->

@extends('front.layouts.app')

@section('content')
<style>
    /* Style for form group */
    .form-group {
        position: relative;
        margin: 20px 0;
    }

    /* Style for input fields */
    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 2px solid #1a73e8;
        border-radius: 4px;
        outline: none;
    }

    /* Style for floating labels */
    .form-group label {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: #fff;
        padding: 0 5px;
        font-size: 14px;
        color: #5f6368;
        transition: all 0.2s ease;
        pointer-events: none;
    }

    /* Move label up when input is focused or not empty */
    .form-control:focus+label,
    .form-control:not(:placeholder-shown)+label {
        top: -10px;
        font-size: 12px;
        color: #1a73e8;
    }

    /* Error handling for input fields */
    .is-invalid {
        border-color: red;
    }

    .invalid-feedback {
        color: red;
        font-size: 12px;
    }

    /* Forgot password link */
    .forgot-link {
        color: #1a73e8;
        text-decoration: none;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    /* Submit button */
    .btn-dark {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 10px;
        font-size: 16px;
        width: 100%;
        cursor: pointer;
    }

    .btn-dark:hover {
        background-color: #555;
    }

    /* Checkbox styling */
    .show-password {
        margin-top: 10px;
        display: flex;
        align-items: center;
    }

    .show-password label {
        margin-left: 5px;
    }
</style>

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
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
                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder=" "
                        name="email" value="{{ old('email') }}" id="email">
                    <label for="email">Email</label>
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder=" ">
                    <label for="password">Password</label>
                    @error('password')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group show-password">
                    <input type="checkbox" id="show-password-checkbox" onclick="togglePassword()">
                    <label for="show-password-checkbox">Show Password</label>
                </div>

                <div class="form-group small">
                    <a href="{{ route('front.forgotPassword')}}" class="forgot-link">Forgot Password ?</a>
                </div>

                <input type="submit" class="btn btn-dark btn-block btn-lg" value="Login">
                <div class="d-flex justify-content-center">
                    <a class="btn btn-outline-light" href="{{ route('google.login') }}">
                        <img class="shadow-lg   rounded" src="{{ asset('front-assets/images/GoogleSignUpDark.png') }}"
                            alt="Google Login" style="height: 50px; width: auto;">
                    </a>
                </div>

            </form>


            <div class="text-center small">Don't have an account? <a href="{{ route('account.register') }}">Sign up</a>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
    // Function to toggle password visibility
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var checkbox = document.getElementById("show-password-checkbox");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
</script>
@endsection