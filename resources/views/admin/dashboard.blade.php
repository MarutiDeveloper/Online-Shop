@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 style="font-family: 'Times New Roman', Times, serif; font-weight: bold ;">Dashboard </h1>
            </div>
            <div class="col-sm-6">

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
            <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <a href="javascript:void(0);" class="small-box-footer">&nbsp;<strong style="color: black ;">Total
                            Orders</strong></a>
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>

                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer text-dark">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                    <!-- <a href="javascript:void(0);" class="small-box-footer">&nbsp;<strong style="color: black ;">Total
                            Orders</strong></a> -->
                    <!-- <a href="#" class="small-box-footer text-dark">More info <i
                            class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <a href="javascript:void(0);" class="small-box-footer">&nbsp;<strong style="color: black ;">Total
                            Products</strong></a>
                    <div class="inner">
                        <h3>{{ $totalProducts }}</h3>

                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('product.index') }}" class="small-box-footer text-dark">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                    <!-- <a href="javascript:void(0);" class="small-box-footer">&nbsp;<strong style="color: black ;">Total
                            Products</strong></a> -->
                    <!-- <a href="#" class="small-box-footer text-dark">More info <i
                            class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <a href="javascript:void(0);" class="small-box-footer">&nbsp;<strong style="color: black ;">Total
                            Customers</strong></a>
                    <div class="inner">
                        <h3>{{ $totalCustomers }}</h3>
                       
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer text-dark">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                    <!-- <a href="javascript:void(0);" class="small-box-footer">&nbsp;<strong style="color: black ;">Total
                            Customers</strong></a> -->
                    <!-- <a href="#" class="small-box-footer text-dark">More info <i
                            class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box card" style="position: relative; overflow: hidden;">
                    <!-- Watermark -->
                    <div
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 3rem; color: rgba(0, 0, 0, 0.1); z-index: 0; font-family: 'Times New Roman', Times, serif;">
                        ₹ Revenue
                    </div>

                    <div class="inner" style="position: relative; z-index: 1;">
                        <strong class="text-center">Total Revenue</strong>
                        <h5 style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                            <span class="rupee-icon">₹</span> {{ number_format($totalRevenue, 2) }}&nbsp;/-
                        </h5>

                    </div>
                    <div class="icon" style="position: relative; z-index: 1;">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="javascript:void(0);" class="small-box-footer" style="position: relative; z-index: 1;">
                        &nbsp;<strong style="color: black;">Total Revenue</strong>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box card" style="position: relative; overflow: hidden;">
                    <!-- Watermark -->
                    <div
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 3rem; color: rgba(0, 0, 0, 0.1); z-index: 0; font-family: 'Times New Roman', Times, serif;">
                        ₹ Revenue
                    </div>

                    <div class="inner" style="position: relative; z-index: 1;">
                        <strong class="text-center"> Total Revenue This Months</strong>
                        <h5 style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">

                            <span class="rupee-icon">₹</span> {{ number_format($revenueThisMonth, 2) }}&nbsp;/-
                        </h5>

                    </div>
                    <div class="icon" style="position: relative; z-index: 1;">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="javascript:void(0);" class="small-box-footer" style="position: relative; z-index: 1;">
                        &nbsp;<strong style="color: black;">Total Revenue This Months</strong>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box card" style="position: relative; overflow: hidden;">
                    <!-- Watermark -->
                    <div
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 3rem; color: rgba(0, 0, 0, 0.1); z-index: 0; font-family: 'Times New Roman', Times, serif;">
                        ₹ Revenue
                    </div>

                    <div class="inner" style="position: relative; z-index: 1;">
                        <strong class="text-center"> Total Revenue Last Months - ({{ $lastMonthName }})</strong>
                        <h5 style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">

                            <span class="rupee-icon">₹</span> {{ number_format($revenueLastMonth, 2) }}&nbsp;/-
                        </h5>

                    </div>
                    <div class="icon" style="position: relative; z-index: 1;">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="javascript:void(0);" class="small-box-footer" style="position: relative; z-index: 1;">
                        &nbsp;<strong style="color: black;">Total Revenue Last Months {{ $lastMonthName }}</strong>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box card" style="position: relative; overflow: hidden;">
                    <!-- Watermark -->
                    <div
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 3rem; color: rgba(0, 0, 0, 0.1); z-index: 0; font-family: 'Times New Roman', Times, serif;">
                        ₹ Revenue
                    </div>

                    <div class="inner" style="position: relative; z-index: 1;">
                        <strong class="text-center"> Total Revenue Last 30 Days</strong>
                        <h5 style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">

                            <span class="rupee-icon">₹</span> {{ number_format($revenueLastThirtyDays, 2) }}&nbsp;/-
                        </h5>

                    </div>
                    <div class="icon" style="position: relative; z-index: 1;">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="javascript:void(0);" class="small-box-footer" style="position: relative; z-index: 1;">
                        &nbsp;<strong style="color: black;"> Total Revenue Last 30 Days</strong>
                    </a>
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
    console.log("Hello !")
</script>

@endsection