@extends('front.layouts.app')

@section('content')
    <div class="header">
        <h1>Invoice #{{ $invoiceData['id'] }}</h1>
        <p>Date: {{ $invoiceData['date'] }}</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoiceData['items'] as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p>Discount: ${{ number_format($invoiceData['discount'], 2) }}</p>
        <p>Shipping Charge: ${{ number_format($invoiceData['shipping_charge'], 2) }}</p>
        <p><strong>Total: ${{ number_format($invoiceData['total'], 2) }}</strong></p>
    </div>
@endsection
