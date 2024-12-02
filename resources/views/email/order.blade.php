<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Email</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
   
    <style>
          .card-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .rounded-circle {
            border-radius: 50% !important;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .bg-light {
            background-color: #FFF5F3 !important;
        }

        .name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 15px;
        }

        .title {
            font-size: 1.1rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 20px;
        }

        .contact-info {
            font-size: 1rem;
            line-height: 1.6;
        }

        .contact-info strong {
            display: inline-block;
            width: 70px;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #f8f8f8;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .bg-light {
            background-color: #FFF5F3 !important;
        }
    </style>
</head>

<body>
    <div class="text-center" style="padding: 20px;">
        @if ($mailData['userType'] == 'customer')
        <h1>Thank You for Shopping!</h1>
        <hr>
        <h3 id="order-id">Your Order ID is: #012345 - {{ $mailData['order']->id }}</h3>
        @else
        <h1>You have Received an Order...!</h1>
        <hr>
        <h3 id="order-id">Order ID is: #012345 - {{ $mailData['order']->id }}</h3>
        @endif
        
        <!-- Add current date -->
        <h4>Date: {{ now()->format('l, F j, Y') }}</h4> <!-- Example format: "Friday, November 30, 2024" -->
        

        <h4>Product(s) Ordered:</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="100">Price</th>
                    <th width="100">Qty</th>
                    <th width="100">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mailData['order']->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-left">₹{{ number_format($item->price, 2) }}/-</td>
                        <td>{{ $item->qty }}</td>
                        <td class="text-left">₹{{ number_format($item->total, 2) }}/-</td>
                    </tr>
                @endforeach

                <tr>
                    <th colspan="3" class="text-right text-muted">Subtotal:</th>
                    <td class="text-left">₹{{ number_format($mailData['order']->subtotal, 2) }}/-</td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right text-muted">
                        Discount:
                        {{ !empty($mailData['order']->coupon_code) ? '(' . $mailData['order']->coupon_code . ')' : '' }}
                    </th>
                    <td class="text-left">₹{{ number_format($mailData['order']->discount, 2) }}/-</td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right text-muted">Shipping:</th>
                    <td class="text-left">₹{{ number_format($mailData['order']->shipping, 2) }}/-</td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right text-muted">Grand Total:</th>
                    <td class="text-left">₹{{ number_format($mailData['order']->grand_total, 2) }}/-</td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Shipping Address Section -->
    <h4>Shipping Address</h4>
        <address class="text-left">
            <strong>{{ $mailData['order']->first_name . ' ' . $mailData['order']->last_name }}</strong><br>
            {{ $mailData['order']->address }},<br>
            {{ $mailData['order']->city }}, {{ $mailData['order']->state }}, {{ $mailData['order']->zip }},
            {{ getCountryInfo($mailData['order']->country_id)->name }}.<br><br>
            Phone: {{ $mailData['order']->mobile }}<br>
            Email: {{ $mailData['order']->email }}
        </address>

</body>

</html>
