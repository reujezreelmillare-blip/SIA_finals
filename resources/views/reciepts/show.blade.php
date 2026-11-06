
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Receipt | GownEase</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 40px 15px;
            background: #f8f5f0;
            color: #302438;
            font-family: 'Poppins', sans-serif;
        }

        .receipt {
            max-width: 850px;
            margin: auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(48,36,56,.08);
        }

        .header {
            background: #302438;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            margin: 0;
        }

        .subtitle {
            color: #d8b994;
            letter-spacing: 4px;
            font-size: 11px;
            margin-top: 8px;
        }

        .content { padding: 35px; }

        .receipt-title {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            text-align: center;
            margin-bottom: 5px;
        }

        .description {
            text-align: center;
            color: #897c8c;
            font-size: 13px;
            margin-bottom: 30px;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .detail-box {
            background: #f8f5f0;
            padding: 15px;
            border-radius: 6px;
        }

        .detail-box small {
            color: #897c8c;
            display: block;
            margin-bottom: 5px;
        }

        h3 {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 10px;
            border-bottom: 1px solid #eee7df;
            text-align: left;
            font-size: 13px;
        }

        th {
            background: #f8f5f0;
            color: #66576b;
        }

        .amount { text-align: right; }

        .total-section {
            background: #f8f5f0;
            padding: 22px;
            margin-top: 25px;
            border-radius: 6px;
        }

        .grand-total {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: #302438;
            text-align: right;
            margin-top: 8px;
        }

        .status {
            display: inline-block;
            background: #fff0d8;
            color: #92652e;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .footer {
            text-align: center;
            color: #897c8c;
            font-size: 12px;
            padding: 25px;
        }

        .actions {
            max-width: 850px;
            margin: 25px auto;
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            text-decoration: none;
            text-align: center;
            padding: 14px;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            border: 1px solid #302438;
            cursor: pointer;
        }

        .btn-primary {
            background: #302438;
            color: white;
        }

        .btn-outline {
            background: white;
            color: #302438;
        }

        @media(max-width: 600px) {
            .details { grid-template-columns: 1fr; }
            .content { padding: 20px; }
            .actions { flex-direction: column; }
        }

        @media print {
            body { background: white; padding: 0; }
            .receipt { box-shadow: none; }
            .actions { display: none; }
        }
    </style>
</head>

<body>

<div class="receipt">

    <div class="header">
        <h1 class="brand">GownEase</h1>
        <div class="subtitle">GOWN RENTAL COLLECTION</div>
    </div>

    <div class="content">

        <h2 class="receipt-title">Rental Receipt</h2>

        <p class="description">
            Thank you for choosing GownEase!
        </p>

        <div class="details">

            <div class="detail-box">
                <small>Receipt Number</small>
                <strong>
                    GE-{{ str_pad($bookings->first()->id, 6, '0', STR_PAD_LEFT) }}
                </strong>
            </div>

            <div class="detail-box">
                <small>Booking Date</small>
                <strong>
                    {{ \Carbon\Carbon::parse($bookings->first()->created_at)->format('F d, Y') }}
                </strong>
            </div>

            <div class="detail-box">
                <small>Customer Name</small>
                <strong>{{ auth()->user()->name }}</strong>
            </div>

            <div class="detail-box">
                <small>Booking Status</small>
                <span class="status">
                    {{ ucfirst($bookings->first()->status) }}
                </span>
            </div>

            <div class="detail-box">
                <small>Payment Method</small>
                <strong>{{ $paymentMethod }}</strong>
            </div>

        </div>

        <h3>Rental Details</h3>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Rental Period</th>
                    <th class="amount">Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach($bookings as $booking)
                    @php
                        preg_match('/Quantity:\s*(\d+)/', $booking->notes ?? '', $matches);
                        $quantity = isset($matches[1]) ? (int) $matches[1] : 1;
                    @endphp

                    <tr>
                        <td>
                            <strong>{{ $booking->gown_name }}</strong>
                            <br>
                            <small>Quantity: {{ $quantity }}</small>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}
                            <br>
                            to
                            <br>
                            {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                        </td>

                        <td class="amount">
                            ₱{{ number_format($booking->total_price, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div style="text-align:right; font-size:13px;">
                TOTAL RENTAL AMOUNT
            </div>

            <div class="grand-total">
                ₱{{ number_format($total, 2) }}
            </div>
        </div>

        <div style="margin-top:25px;">
            <strong>Payment Information</strong>

            <p style="font-size:13px; color:#897c8c;">
                @if($paymentMethod === 'GCash')
                    Your GCash payment is pending verification.
                @else
                    Please pay at the GownEase store.
                @endif
                Your rental booking is subject to approval.
            </p>
        </div>

    </div>

    <div class="footer">
        GownEase Collection<br>
        Please keep this receipt for your rental records.
    </div>

</div>

<div class="actions">

    <button onclick="window.print()" class="btn btn-outline">
        Print Receipt
    </button>

    <a href="{{ url('/') }}" class="btn btn-primary">
        Back to Home
    </a>

    <a href="{{ route('shop') }}" class="btn btn-outline">
        Continue Ordering
    </a>

</div>

</body>
</html>
