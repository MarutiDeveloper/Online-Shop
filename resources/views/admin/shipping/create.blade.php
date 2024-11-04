@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shipping Management</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <!-- Default box -->
    <div class="container-fluid">
        @include("admin.message")
        <form action="" method="post" id="shippingForm" name="shippingForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">

                                <select name="country" id="country" class="form-control text-uppercase">
                                    <option value="">Select a Country</option>
                                    @if ($countries->isNotEmpty())
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                        <option value="rest_of_world">Rest of the World</option>
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <select name="state" id="state" class="form-control text-uppercase">
                                    <option value="">Select a State</option>
                                    @if ($states->isNotEmpty())
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                        <option value="rest_of_state">Rest of the State</option>
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <select name="city" id="city" class="form-control text-uppercase">
                                    <option value="">Select a City</option>
                                    @if ($city->isNotEmpty())
                                        @foreach ($city as $cityes)
                                            <option value="{{ $cityes->id }}">{{ $cityes->name }}</option>
                                        @endforeach
                                        <option value="rest_of_city">Rest of the City</option>
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <div class="card"
            style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Country-Name</th>
                                <th>State-Name</th>
                                <th>City-Name</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            @if ($shippingCharges->isNotEmpty())
                                @foreach ($shippingCharges as $shippingCharge)
                                    <tr>
                                        <td>{{  $shippingCharge->id }}</td>
                                        <td>
                                            {{ $shippingCharge->country_id == 'rest_of_world' ? 'Rest of the World' : ($shippingCharge->country->name ?? 'No Country') }}
                                        </td>
                                        <td>
                                            {{ $shippingCharge->state_id == 'rest_of_state' ? 'Rest of the State' : ($shippingCharge->state->name ?? 'No State') }}
                                        </td>
                                        <td>
                                            {{ $shippingCharge->city_id == 'rest_of_city' ? 'Rest of the City' : ($shippingCharge->city->name ?? 'No City') }}
                                        </td>
                                        <td><span style="font-weight:bolder">$. </span>{{  $shippingCharge->amount }}</td>
                                        <td>
                                            <a href="{{ route('shipping.edit', $shippingCharge->id) }}"
                                                class="btn btn-outline-light btn-primary">Edit</a>
                                            <a href="javascript:void(0);" onclick="deleteRecord({{ $shippingCharge->id }});"
                                                class="btn btn-outline-light btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $("#shippingForm").submit(function (event) {
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("shipping.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function (response) {
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] == true) {

                    window.location.href = "{{ route('shipping.create') }}";


                } else {
                    var errors = response['errors'];
                    if (errors['country']) {
                        $("#country").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors['country']);
                    } else {
                        $("#country").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }
                    if (errors['state']) {
                        $("#state").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors['state']);
                    } else {
                        $("#state").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }
                    if (errors['city']) {
                        $("#city").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors['city']);
                    } else {
                        $("#city").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }

                    if (errors['amount']) {
                        $("#amount").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors['amount']);
                    } else {
                        $("#amount").removeClass('is-invalid').siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }
                }

            }, error: function (jqXHR, exception) {
                console.log("Something went wrong");
            }
        });
    });



    function deleteRecord(id) {

        var url = '{{ route("shipping.destroy", "ID") }}';
        var newUrl = url.replace("ID", id)

        if (confirm("Are you sure you want to Delete...?")) {
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response["status"]) {
                        window.location.href = "{{ route('shipping.create') }}";
                    }
                }
            });
        }
    }


</script>

@endsection