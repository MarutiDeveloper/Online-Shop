@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('product.create') }}" class="btn btn-primary">New Product</a>
            </div>
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
                        <button type="button" onclick="window.location.href='{{ route('product.index') }}'"
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
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>SKU</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products->isNotEmpty())
                                            @foreach ($products as $product)
                                                                @php
                                                                    $productImage = $product->product_images->first();
                                                                    $imagePath = $productImage ? 'uploads/product/large/' . $productImage->image : '';
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $product->id }}</td>
                                                                    <td>
                                                                        @if (!empty($productImage) && file_exists(filename: public_path(path: $imagePath)))
                                                                            <img src="{{ asset(path: $imagePath) }}?v={{ time() }}" class="img-thumbnail" width="50"
                                                                                onerror="this.onerror=null; this.src='{{ asset(path: 'admin-assets/img/default-150x150.png') }}';"
                                                                                alt="Product Image" />
                                                                        @else
                                                                            <img src="{{ asset('admin-assets/img/default-150x150.png') }}" class="img-thumbnail"
                                                                                width="50" alt="Default Image" />
                                                                        @endif
                                                                    </td>
                                                                    <td><a href="{{ route('product.edit', $product->id) }}">{{ $product->title }}</a></td>
                                                                    <td>₹ {{ $product->price }}</td>
                                                                    <td>{{ $product->qty }} </td>
                                                                    <td>{{ $product->sku }}</td>
                                                                    <td>
                                                                        @if ($product->status == 1)
                                                                            <svg class="text-success h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                            </svg>
                                                                        @else
                                                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                            </svg>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('product.edit', $product->id) }}">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <a href="#" class="text-danger" onclick="deleteProduct({{ $product->id }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
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
                {{ $products->links() }}
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
</script>
@endsection