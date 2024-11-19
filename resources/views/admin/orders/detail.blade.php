@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order : #4F3S8J-{{ $order->id }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('orders.index') }}" class="btn btn-primary">Back</a>
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
        <div class="row">
            <div class="col-md-9">
                @include("admin.message")
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <h1 class="h5 mb-3">Shipping Address</h1>
                                <address>
                                    <strong>{{ $order->first_name . ' ' . $order->last_name }}</strong><br>
                                    {{  $order->address }}<br>
                                    {{  $order->city }}, {{  $order->zip }} <br>{{ $order->countryName }}<br>
                                    Phone: {{  $order->mobile }}<br>
                                    Email: {{  $order->email }}
                                </address>
                                <strong class="text-muted">Shipped Date :</strong><br>
                                <time datetime="2019-10-01">
                                    <td style="text-align: center;">
                                        @if (!empty($order->shipped_date))
                                            {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y') }}
                                        @else
                                            <span class="text-muted" style="color: red; font-weight: bold;">N/A</span>
                                        @endif
                                    </td>
                                </time>
                            </div>



                            <div class="col-sm-5 invoice-col">
                                <!-- <b>Invoice #007612</b><br> -->
                                <!-- <br> -->
                                <b>Order ID :</b> <b style="box-shadow:inset ;  ;">#4F3S8J-{{ $order->id }}</b><br>
                                <b>Total:</b> <i class="fas fa-rupee-sign" style="font-weight: bold;">.
                                </i>{{ number_format($order->grand_total, 2) }}/-<br>
                                <b style="font-size: 20px;">Status :</b>
                                @if ($order->status == 'pending')

                                    <span class="badge bg-danger" style="font-size: 16px;">Pending</span>

                                @elseif ($order->status == 'shipped')

                                    <span class="badge bg-info" style="font-size: 16px;">Shipped</span>

                                @elseif($order->status == 'delivered')

                                    <span class="badge bg-success" style="font-size: 16px;">Delivered</span>

                                @else

                                    <span class="badge bg-danger" style="font-size: 16px;">Cancelled</span>


                                @endif
                                <!-- <span class="text-success">Delivered</span> -->

                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <h6>
                            <table class="table table-bordered" style="border: radius: 5px; ;">
                                <h4>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th width="100">Price</th>
                                            <th width="100">Qty</th>
                                            <th width="100">Total</th>
                                        </tr>
                                    </thead>
                                </h4>

                                <tbody>
                                    @foreach ($orderItems as $item)
                                        <h5>
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td class="text-left">₹{{ number_format($item->price, 2) }}/-</td>
                                                <td>{{ $item->qty }}</td>
                                                <td class="text-left">₹{{ number_format($item->total, 2) }}/-</td>
                                            </tr>
                                        </h5>
                                    @endforeach

                                    <tr>
                                        <th colspan="3" class="text-right text-muted">Subtotal :</th>
                                        <td class="text-left">
                                            <i class="fas fa-rupee-sign"></i>
                                            {{ number_format($order->subtotal, 2) }}
                                        </td>
                                    </tr>

                                    <tr>

                                        <th colspan="3" class="text-right text-muted">Discount :
                                            {{ (!empty($order->coupon_code)) ? '(' . $order->coupon_code . ')' : '' }}
                                        </th>
                                        <td class="text-left">
                                            <i class="fas fa-rupee-sign"></i>
                                            {{ number_format($order->discount, 2) }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <th colspan="3" class="text-right text-muted">Shipping :</th>
                                        <td class="text-left">
                                            <i class="fas fa-rupee-sign"></i>
                                            {{ number_format($order->shipping, 2) }}
                                        </td>
                                        <hr>
                                    </tr>



                                    <tr>
                                        <th colspan="3" class="text-right text-muted">Grand Total :</th>
                                        <td>
                                            <i class="fas fa-rupee-sign"></i>
                                            {{ number_format($order->grand_total, 2) }}
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <form action="" method="post" name="changeOrderStatusForm" id="changeOrderStatusForm">
                        @csrf
                        <div class="card-body">
                            <h2 class="h4 mb-3">Order Status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <h5>
                                        <option class="bg-danger" value="pending" {{ ($order->status == 'pending') ? 'selected' : '' }}>Pending</option>
                                    </h5>
                                    <h5>
                                        <option class="bg-info" value="shipped" {{ ($order->status == 'shipped') ? 'selected' : '' }}>Shipped</option>
                                    </h5>
                                    <h5>
                                        <option class="bg-success" value="delivered" {{ ($order->status == 'delivered') ? 'selected' : '' }}>Delivered</option>
                                    </h5>
                                    <h5>
                                        <option class="bg-danger" value="cancelled" {{ ($order->status == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                                    </h5>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Shipped Date :</label>
                                <input value="{{ $order->shipped_date }}" class="form-control" type="text"
                                    name="shipped_date" id="shipped_date" placeholder="Select Shipped Date">
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" name="sendInvoiceEmail" id="sendInvoiceEmail">
                            <h2 class="h4 mb-3">Send Inovice Email</h2>
                            <div class="mb-3">
                                <select name="userType" id="userType" class="form-control">
                                    <option value="customer">Customer</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Send</button>
                            </div>
                        </form>
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
    $(document).ready(function () {
        $('#shipped_date').datetimepicker({
            // options here
            format: 'Y-m-d H:i:s',
        });
    });

    $("#changeOrderStatusForm").submit(function (evevent) {
        event.preventDefault();

        if (confirm('Are you sure you want to Change Status...?')) {
            $.ajax({
                url: '{{ route("orders.changeOrderStatus", $order->id) }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response) {
                    window.location.href = '{{ route("orders.detail", $order->id) }}';
                }
            });
        }
    });

    $("#sendInvoiceEmail").submit(function (evevent) {
        event.preventDefault();

        if (confirm('Are you sure you want to Send This Mail...?')) {
            $.ajax({
                url: '{{ route("orders.sendInvoiceEmail", $order->id) }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response) {
                    window.location.href = '{{ route("orders.detail", $order->id) }}';
                }
            });
        }


    });


</script>

@endsection