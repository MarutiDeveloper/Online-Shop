@extends('admin.layouts.app')

@section('content')
<style>
    /* Style for form group */
    .form-group {
        position: relative;
        margin: 20px 0;
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
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create New User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include("admin.message")
        <form action="" method="post" id="userForm" name="userForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-muted"
                            style="font-family: 'Times New Roman', Times, serif ;font-weight: bolder ; ">
                            <div class="mb-3">
                                <label for="name">Enter Your Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                    spellcheck="true">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6 text-muted"
                            style="font-family: 'Times New Roman', Times, serif ;font-weight: bolder ; ">
                            <div class="mb-3">
                                <label for="email">Enter Your Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email"
                                    spellcheck="true">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6 text-muted"
                            style="font-family: 'Times New Roman', Times, serif ;font-weight: bolder ; ">
                            <div class="mb-3">
                                <label for="password">Enter Your Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter Your Password" spellcheck="true">
                                <p></p>
                                <div class="form-group show-password">
                                    <input type="checkbox" id="show-password-checkbox" onclick="togglePassword()">
                                    <label for="show-password-checkbox">Show Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-muted"
                            style="font-family: 'Times New Roman', Times, serif ;font-weight: bolder ; ">
                            <div class="mb-3">
                                <label for="phone">Enter Your Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone"
                                    spellcheck="true">
                                <p></p>
                            </div>
                        </div>


                        <div class="col-md-6 text-muted"
                            style="font-family: 'Times New Roman', Times, serif ;font-weight: bolder ; ">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" style="font-family: 'Times New Roman', Times, serif;">Active
                                    </option>
                                    <option value="0" style="font-family: 'Times New Roman', Times, serif;">Block
                                    </option>
                                </select>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3 text-muted" style="font-family:fantasy ; ">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
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



    $("#userForm").submit(function (event) {
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("users.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function (response) {
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] == true) {

                    window.location.href = "{{ route('users.index') }}";

                    $("#name").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html("");

                    $("#email").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $("#password").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $("#phone").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html("");
                } else {
                    var errors = response['errors'];
                    if (errors['name']) {
                        $("#name").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors['name']);
                    } else {
                        $("#name").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }

                    if (errors['email']) {
                        $("#email").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors['email']);
                    } else {
                        $("#email").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }
                    if (errors['password']) {
                        $("#password").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors['password']);
                    } else {
                        $("#password").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }
                    if (errors['phone']) {
                        $("#phone").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors['phone']);
                    } else {
                        $("#phone").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }
                }

            }, error: function (jqXHR, exception) {
                console.log("Something went wrong");
            }
        });
    });





</script>

@endsection