@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 "
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container  mt-5">
        <div class="row">

            @include('front.account.common.message')

            <div class="col-md-3">

                @include('front.account.common.sidebar')

            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2" >Change Password</h2>
                    </div>
                    <form action="" method="post" id="changePasswordForm" name="changePasswordForm">
                        @csrf
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name">Old Password</label>
                                    <!-- <input type="password" name="old_password" id="old_password" placeholder="Old Password"
                                    class="form-control"> -->
                                    <input type="password" class="form-control" placeholder="Old Password"
                                        id="old_password" name="old_password">
                                    <p></p>
                                    <input type="checkbox" onclick="oldPassword()"> <label
                                        style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; ;">Show
                                        Password</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="name">New Password</label>
                                <!-- <input type="password" name="new_password" id="new_password" placeholder="New Password"
                                class="form-control"> -->
                                <input type="password" class="form-control" placeholder="New Password" id="new_password"
                                    name="new_password">
                                <p></p>
                                <input type="checkbox" onclick="newPassword()"> <label
                                    style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; ;">Show
                                    Password</label>
                            </div>
                            <div class="mb-3">
                                <label for="name">Confirm Password (New-Password)</label>
                                <!-- <input type="password" name="confirm_password" id="confirm_password"
                                placeholder="Old Password" class="form-control"> -->
                                <input type="password" class="form-control" placeholder="Confirm Password (New-Password)"
                                    id="confirm_password" name="confirm_password">
                                <p style="font-size: larger ; "></p>
                                <input type="checkbox" onclick="confPassword()"> <label
                                    style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; ;">Show
                                    Password</label>
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-outline-light btn-primary">
                                    <i class="fas fa-sync-alt"></i> Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
    function oldPassword() {
        var x = document.getElementById("old_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function newPassword() {
        var x = document.getElementById("new_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function confPassword() {
        var x = document.getElementById("confirm_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<script type="text/javascript">
        $("#changePasswordForm").submit(function (e) {
            e.preventDefault();

            $.ajax({
                    url: '{{ route("account.processChangePassword") }}',
                    type: 'post',
                    data: $(this).serializeArray(),
                    dataType: 'json',
                    success:function (response) {
                            if (response.status == true) {
                                window.location.href="{{ route('account.changePassword') }}";
                            }else {
                                var errors = response.errors;
                                if (errors.old_password) {
                                    $("#old_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.old_password)
                                }else {
                                    $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                                }
                                if (errors.new_password) {
                                    $("#new_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.new_password)
                                }else {
                                    $("#new_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                                }
                                if (errors.confirm_password) {
                                    $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password)
                                }else {
                                    $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                                }
                            }
                    }
            });

        })
</script>
@endsection