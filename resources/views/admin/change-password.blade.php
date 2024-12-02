@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container-fluid my-2" style="font-family:'Times New Roman', Times, serif ;font: size 14px; ">
        <div class="card-header bg-dark">
            <h2 class="h5 mb-0 pt-2 pb-2" style="color: tomato;">
                <i class="fas fa-key" style="margin-right: 10px;"></i> Change Password
            </h2>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <!-- Default box -->
    <div class="container-fluid" style="font-family:'Times New Roman', Times, serif ;font: size 14px; ">
        @include("admin.message")
        <form action="" method="post" id="changePasswordForm" name="changePasswordForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <div class="mb-3">
                                <label for="name">Old Password<strong style="color: red ; ">*</strong></label>
                                <input type="password" name="old_password" id="old_password" class="form-control"
                                    placeholder="Enter Your Old Password Here...">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <div class="mb-3">
                                <label for="name">New Password<strong style="color: red ; ">*</strong></label>
                                <input type="password" name="new_password" id="new_password" class="form-control"
                                    placeholder="Enter Your New Password Here...">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <div class="mb-3">
                                <label for="name">Confirm Password<strong style="color: red ; ">*</strong></label>
                                <input type="password" name="conf_password" id="conf_password" class="form-control"
                                    placeholder="Please Confirm Your New Password...">
                                <p></p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn shadow-lg   bg-body circle  btn-primary"><i
                        class="fas fa-sync-alt"></i> UPDATE</button>

            </div>

        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $("#changePasswordForm").submit(function (event) {
        event.preventDefault();

        var element = $(this);
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("admin.processChangePassword") }}',
            type: 'POST',
            data: element.serializeArray(),
            dataType: 'json',
            success: function (response) {
                $("button[type=submit]").prop('disabled', false);

                if (response.status === true) {
                    // Redirect on success
                    window.location.href = "{{ route('admin.showChangePasswordForm') }}";


                } else {
                    var errors = response.errors;

                    // Handle `old_password` errors
                    if (errors.old_password) {
                        $("#old_password").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors.old_password);
                    } else {
                        $("#old_password").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }

                    // Handle `new_password` errors
                    if (errors.new_password) {
                        $("#new_password").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors.new_password);
                    } else {
                        $("#new_password").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }

                    // Handle `conf_password` errors
                    if (errors.conf_password) {
                        $("#conf_password").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors.conf_password);
                    } else {
                        $("#conf_password").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }
                }
            },
            error: function (jqXHR, exception) {
                console.log("Something went wrong");
            }
        });
    });




</script>

@endsection