@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6 d-flex align-items-center">
                <!-- Icon for the Page -->
                <i class="nav-icon fas fa-star mr-3" style="font-size: 2rem;"></i>

                <!-- Page Title -->
                <h1 class="font-weight-bold mb-0" style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif font-size: 1.75rem;">Product Rating Page</h1>
            </div>

            <!-- <div class="col-sm-6 text-right">
                <a href="{{ route('product.create') }}" class="btn btn-primary">New Product</a>
            </div> -->
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @include("admin.message")

        <div class="card">
            <form action="" method="get">
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route('product.productRatings') }}'"
                            class="btn btn-default btn-sm" style="font-family:'Times New Roman';">Reset</button>
                    </div>
                    <div class="card-tools">
                        <div class="input-group" style="width: 250px;">
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
                    <thead class="text-uppercase text-primary bg-dark"
                        style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
                        <tr>
                            <th>ID</th>
                            <th>Product - Title</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Rated By </th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-uppercase"
                        style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ;">
                        @if ($ratings->isNotEmpty())
                            @foreach ($ratings as $rating)

                                <tr>
                                    <td>{{ $rating->id }}</td>

                                    <td>{{ $rating->productTitle }}</td>
                                    <td>{{ $rating->rating }}</td>
                                    <td>{{ $rating->comment }} </td>
                                    <td>{{ $rating->username }}</td>
                                    <td>
                                        @if ($rating->status == 1)
                                            <a href="javascript:void(0)" onclick="changeStatus(0, '{{ $rating->id }}');">
                                                <svg class="text-success h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" onclick="changeStatus(1, '{{ $rating->id }}');">
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center font-weight-bold">No Records Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $ratings->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: `/admin/products/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        $(`#product-row-${id}`).remove();
                        alert(response.message);
                        window.location.href = "{{ route('product.index') }}";
                    } else {
                        alert('Failed to delete product. Please try again.');
                    }
                },
                error: function (xhr) {
                    alert(xhr.responseJSON?.message || 'An error occurred.');
                }
            });
        }
    }
    function changeStatus(status, id) {
        if (confirm('Are you sure you want to Change Status ?')) {
            $.ajax({
                url: '{{ route("product.changeRatingStatus") }}',
                type: 'get',
                data: { status: status, id: id },
                dataType: 'json',
                success: function (response) {
                    window.location.href = "{{ route('product.productRatings') }}";
                }
            });
        }
    }
</script>
@endsection