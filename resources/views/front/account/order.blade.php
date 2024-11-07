@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile') }}">My Account</a>
                </li>
                <li class="breadcrumb-item">My Orders</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 "
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h3 mb-0 pt-2 pb-2">My Orders</h2>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <h3>
                                            <th>Orders #</th>
                                        </h3>
                                        <h3>
                                            <th>Date Purchased</th>
                                        </h3>
                                        <h3>
                                            <th>Status</th>
                                        </h3>
                                        <h3><strong>
                                                <th>Total</th>
                                            </strong></h3>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders->isNotEmpty())
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    <h5><a href="{{ route('account.orderDetail', $order->id) }}">{{ $order->id }}</a></h5>
                                                </td>
                                                <h5>
                                                    <td>{{  \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                                                </h5>
                                                <td style="font-family:'Times New Roman', Times, serif ;">
                                                    @if ($order->status == 'pending')
                                                    <h5><span class="badge bg-danger">Pending</span></h5>
                                                    @elseif ($order->status == 'shipped')
                                                    <h5><span class="badge bg-info">Shipped</span></h5>
                                                    @else
                                                    <h5><span class="badge bg-success">Delivered</span></h5>
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    <h4><strong style="color: #28a745; font-size: 18px;"><span>₹.
                                                            </span>{{ number_format($order->grand_total,2) }}/-</strong></h4>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @else
                                        <tr>
                                            <td colspan="3"
                                                style="font-family:'Times New Roman', Times, serif; text-align: center; vertical-align: middle; font-size: 18px; color: red; font-weight: bold;">
                                                Orders Not Found
                                            </td>
                                        </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">

</script>
@endsection