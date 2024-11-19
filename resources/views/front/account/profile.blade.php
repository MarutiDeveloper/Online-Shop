@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">

            @include('front.account.common.message')

            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <form action="" method="post" name="profileForm" id="profileForm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value="{{ $user->name }}" type="text" name="name" id="name"
                                        placeholder="Enter Your Name" class="form-control">
                                    <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input value="{{ $user->email }}" type="text" name="email" id="email"
                                        placeholder="Enter Your Email" class="form-control">
                                    <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input value="{{ $user->phone }}" type="text" name="phone" id="phone"
                                        placeholder="Enter Your Phone" class="form-control">
                                    <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                    </p>
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-dark">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card  mt-5" style="font-family:'Times New Roman', Times, serif ;font: size 14px; ">
                    <div class="card-header bg-dark">
                        <h2 class="h5 mb-0 pt-2 pb-2" style="color:white ;;">Address</h2>
                    </div>
                    <form action="" method="post" name="addressForm" id="addressForm">
                        <div class="card-body p-4">
                            <div class="row">

                                <div class="col-md-6 mb-1">
                                    <h4 style="font-weight:bolder ;"><label for="name" style="font: size 18px;;" class=" text-muted">Enter Your First
                                            Name :</label></h4>
                                    <input value="{{ (!empty($address)) ? $address->first_name : '' }}" type="text" name="first_name" id="first_name"
                                        placeholder="Enter Your First Name" class="form-control">
                                    <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                    </p>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <h4 style="font-weight:bolder ;"><label for="name" style="font: size 18px;;" class=" text-muted">Enter Your Last
                                            Name :</label></h4>
                                    <input value="{{ (!empty($address)) ? $address->last_name : '' }}" type="text" name="last_name" id="last_name"
                                        placeholder="Enter Your Last Name" class="form-control">
                                    <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                    </p>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <h4 style="font-weight:bolder ;"><label for="email" style="font: size 18px;;" class=" text-muted">Enter Your
                                            Email : </label></h4>
                                    <input value="{{ (!empty($address)) ? $address->email : '' }}" type="text" name="email" id="email"
                                        placeholder="Enter Your Email" class="form-control">
                                    <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                    </p>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <h4 style="font-weight:bolder ;"><label for="mobile" style="font: size 18px;;" class=" text-muted">Enter Your
                                            Mobile : </label></h4>
                                    <input value="{{ (!empty($address)) ? $address->mobile : '' }}" type="text" name="mobile" id="mobile"
                                        placeholder="Enter Your Mobile" class="form-control">
                                    <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                    </p>
                                </div>

                                <div class="col-md-12">
                                <div class="mb-1">
                                    <h4 style="font-weight:bolder ;">
                                        <label for="country_id" style="font-size: 18px;"
                                            class="text-muted">Country:</label>
                                    </h4>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="">Select a Country</option>
                                        @if ($countries->isNotEmpty())
                                            @foreach ($countries as $country)
                                                <option {{ (!empty($address) && $address->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p style="font-family: 'Times New Roman', Times, serif;"></p>
                                </div>
                            </div>

                            <div class="mb-1">
                                <h4 style="font-weight:bolder ;"><label for="address" style="font: size 18px;;" class=" text-muted">Address :
                                    </label></h4>
                                <textarea  name="address" id="address" cols="30" rows="5" class="form-control"> {{ (!empty($address)) ? $address->address : '' }} </textarea>
                                <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                </p>
                            </div>

                            <div class="mb-1 col-md-6">
                                <h4 style="font-weight:bolder ;"><label for="apartment" style="font: size 18px;;" class=" text-muted">Apartment :
                                    </label></h4>
                                    <input value="{{ (!empty($address)) ? $address->apartment : '' }}" type="text" name="apartment" id="apartment"
                                        placeholder="Enter Your Apartment" class="form-control">
                                <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                </p>
                            </div>

                            <div class="mb-1 col-md-6">
                                <h4 style="font-weight:bolder ;"><label for="city" style="font: size 18px;;" class=" text-muted">City :
                                    </label></h4>
                                    <input value="{{ (!empty($address)) ? $address->city : '' }}" type="text" name="city" id="city"
                                        placeholder="Enter Your City" class="form-control">
                                <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                </p>
                            </div>

                            <div class="mb-1 col-md-6">
                                <h4 style="font-weight:bolder ;"><label for="state" style="font: size 18px;;" class=" text-muted">State :
                                    </label></h4>
                                    <input value="{{ (!empty($address)) ? $address->state : '' }}" type="text" name="state" id="state"
                                        placeholder="Enter Your State" class="form-control">
                                <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                </p>
                            </div>

                            <div class="mb-1 col-md-6">
                                <h4 style="font-weight:bolder ;"><label for="zip" style="font: size 18px;;" class=" text-muted">Zip-Code (Pincode) :
                                    </label></h4>
                                    <input value="{{ (!empty($address)) ? $address->zip : '' }}" type="number" name="zip" id="zip"
                                        placeholder="Enter Your Pincode" class="form-control">
                                <p style="font-variant-emoji:emoji ;font-family:'Times New Roman', Times, serif ;">
                                </p>
                            </div>


                            <div class="d-flex">
                                <button class="btn btn-dark">Update</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
    $("#profileForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: '{{ route("account.updateProfile") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {

                    $("profileForm #name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("profileForm #email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("profileForm #phone").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    window.location.href = '{{ route("account.profile") }}';
                } else {
                    var errors = response.errors;
                    if (errors.name) {
                        $("profileForm #name").addClass('is-invalid').siblings('p').html(errors.name).addClass('invalid-feedback');
                    } else {
                        $("profileForm #name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.email) {
                        $("profileForm #email").addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                    } else {
                        $("profileForm #email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.phone) {
                        $("profileForm #phone").addClass('is-invalid').siblings('p').html(errors.phone).addClass('invalid-feedback');
                    } else {
                        $("profileForm #phone").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                }
            }

        });
    });

    $("#addressForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: '{{ route("account.updateAddress") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {

                    $("#name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("#email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("#phone").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    window.location.href = '{{ route("account.profile") }}';
                } else {
                    var errors = response.errors;
                    if (errors.first_name) {
                        $(" #first_name").addClass('is-invalid').siblings('p').html(errors.first_name).addClass('invalid-feedback');
                    } else {
                        $("#first_name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.last_name) {
                        $("#last_name").addClass('is-invalid').siblings('p').html(errors.last_name).addClass('invalid-feedback');
                    } else {
                        $("#last_name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.email) {
                        $("#addressForm #email").addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                    } else {
                        $("#addressForm #email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.country_id) {
                        $("#country_id").addClass('is-invalid').siblings('p').html(errors.country_id).addClass('invalid-feedback');
                    } else {
                        $("#country_id").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.mobile) {
                        $("#mobile").addClass('is-invalid').siblings('p').html(errors.mobile).addClass('invalid-feedback');
                    } else {
                        $("#mobile").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.address) {
                        $("#address").addClass('is-invalid').siblings('p').html(errors.address).addClass('invalid-feedback');
                    } else {
                        $("#address").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.city) {
                        $("#city").addClass('is-invalid').siblings('p').html(errors.city).addClass('invalid-feedback');
                    } else {
                        $("#city").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.state) {
                        $("#state").addClass('is-invalid').siblings('p').html(errors.state).addClass('invalid-feedback');
                    } else {
                        $("#state").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if (errors.zip) {
                        $("#zip").addClass('is-invalid').siblings('p').html(errors.zip).addClass('invalid-feedback');
                    } else {
                        $("#zip").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                }
            }

        });
    });

    // addressForm
</script>
@endsection