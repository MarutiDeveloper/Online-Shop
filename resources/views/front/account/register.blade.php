@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item">Register</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        <div class="login-form" style="font-family: 'Times New Roman', Times, serif; font-weight: bold ;">
            <form action="" method="post" name="registrationForm" id="registrationForm">
                <h4 class="modal-title">Register Now</h4>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                    <p></p>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                    <p></p>
                </div>
                <div class="form-group">
                    <!-- <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone"> -->
                    <input type="tel" class="form-control" placeholder="Phone" id="phone" name="phone" pattern="[0-9]*"
                        maxlength="15" required>
                    <p></p>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                    <p></p>
                    <input type="checkbox" onclick="myFunction()"> <label
                        style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; ;">Show
                        Password</label>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password"
                        id="password_confirmation" name="password_confirmation">
                    <p></p>
                </div>
                <div class="form-group small">
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                <!-- <div class="d-flex justify-content-center">
                    <a class="btn btn-outline-light" href="{{ route('google.login') }}">
                        <img class="shadow-lg   rounded" src="{{ asset('front-assets/images/GoogleSignUpDark.png') }}"
                            alt="Google Login" style="height: 50px; width: auto;">
                    </a>
                </div> -->
            </form>
            <div class="text-center small">Already have an account? <a href="{{ route('account.login') }}">Login Now</a>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    $("#registrationForm").submit(function (event) {
        event.preventDefault();

        $("button[type=' submit ']").prop('disabled', true);

        $.ajax({
            url: '{{ route("account.processRegister") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                $("button[type=' submit ']").prop('disabled', false);
                var errors = response.errors;

                if (response.status == false) {
                    if (errors.name) {
                        $("#name").siblings("p").addClass('invalid-feedback').html(errors.name);
                        $("#name").addClass('is-invalid');
                    } else {
                        $("#name").siblings("p").removeClass('invalid-feedback').html('');
                        $("#name").removeClass('is-invalid');
                    }

                    if (errors.email) {
                        $("#email").siblings("p").addClass('invalid-feedback').html(errors.email);
                        $("#email").addClass('is-invalid');
                    } else {
                        $("#email").siblings("p").removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid');
                    }

                    if (errors.phone) {
                        $("#phone").siblings("p").addClass('invalid-feedback').html(errors.phone);
                        $("#phone").addClass('is-invalid');
                    } else {
                        $("#phone").siblings("p").removeClass('invalid-feedback').html('');
                        $("#phone").removeClass('is-invalid');
                    }

                    if (errors.password) {
                        $("#password").siblings("p").addClass('invalid-feedback').html(errors.password);
                        $("#password").addClass('is-invalid');
                    } else {
                        $("#password").siblings("p").removeClass('invalid-feedback').html('');
                        $("#password").removeClass('is-invalid');
                    }

                } else {
                    $("#name").siblings("p").removeClass('invalid-feedback').html('');
                    $("#name").removeClass('is-invalid');

                    $("#email").siblings("p").removeClass('invalid-feedback').html('');
                    $("#email").removeClass('is-invalid');

                    $("#phone").siblings("p").removeClass('invalid-feedback').html('');
                    $("#phone").removeClass('is-invalid');

                    $("#password").siblings("p").removeClass('invalid-feedback').html('');
                    $("#password").removeClass('is-invalid');

                    window.location.href = "{{ route('account.login') }}";
                }

            },
            error: function (jQXHR, execption) {
                console.log("Something went wrong");
            }
        });
    });


</script>
@endsection