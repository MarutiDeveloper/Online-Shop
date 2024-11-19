@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders</h1>
            </div>
            <div class="col-sm-6 text-right">

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
        <div class="card">
            <form action="" method="get">
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route('orders.index') }}'"
                            class="btn btn-default btn-sm"
                            style="font-family:'Times New Roman', Times, serif ;">Reset</button>
                    </div>
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input value="{{ Request::get('keyword') }}" type="text" name="keyword"
                                class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60" style="text-align: center;">Order#</th>
                            <th style="text-align: center;">Customer</th>
                            <th style="text-align: center;">Email</th>
                            <th style="text-align: center;">Phone</th>
                            <th width="100" style="text-align: center;">Status</th>
                            <th width="100" style="text-align: center;">Amount</th>
                            <th type="date" width="100" style="text-align: center;">Date of Purchase</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($orders->isNotEmpty())
                            @foreach ($orders as $order)
                                <tr>
                                    <td><a href="{{ route('orders.detail', [$order->id]) }}">{{ $order->id }} </a></td>
                                    <td style="text-align: center;">{{ $order->name }}</td>
                                    <td style="text-align: center;">{{ $order->email }}</td>
                                    <td style="text-align: center;">{{ $order->mobile }}</td>
                                    <td width="100" style="text-align: center;" style="font-family:'Times New Roman', Times, serif ;">
                                        @if ($order->status == 'pending')
                                           
                                                <h5><span class="badge bg-danger">Pending</span></h5>
                                            
                                        @elseif ($order->status == 'shipped')
                                            
                                                <h5><span class="badge bg-info">Shipped</span></h5>
                                            
                                                @elseif($order->status == 'delivered')
                                                    <h5><span class="badge bg-success">Delivered</span></h5>
                                                    @else
                                                    <h5><span class="badge bg-danger">Cancelled</span></h5>
                                                @endif
                                        <td>
                                                <i class="fas fa-rupee-sign" style="font-weight: bold;"> </i>
                                                    {{ number_format($order->grand_total,2) }}/-
                                        </td>
                                        <td type="date">
                                            {{  \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                                        </td>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" style="font-family:'Times New Roman', Times, serif; color: #ff0000;">Record
                                    Not Found..!</td>
                            </tr>
                        @endif


                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix text-center">
                {{ $orders->links()}}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>

</script>

@endsection