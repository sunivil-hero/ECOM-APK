<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Invoice #{{ $order->id }}</title>
    <style>
        /* Modern Reset */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 40px;
            color: #333;
            line-height: 1.5;
        }

        /* Typography */
        h1 { font-size: 28px; font-weight: 300; margin: 0; color: #1a1a1a; }
        h2 { font-size: 18px; font-weight: 700; margin-bottom: 5px; color: #2c3e50; }
        p { margin: 2px 0; font-size: 13px; color: #666; }
        strong { color: #333; }

        /* Header Section */
        .invoice-header {
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 2px solid #3498db; /* Professional Blue Accent */
            padding-bottom: 20px;
        }
        .brand-section { float: left; width: 50%; }
        .status-section { float: right; width: 45%; text-align: right; }

        /* Details Section */
        .info-container { width: 100%; margin-bottom: 30px; }
        .bill-to { float: left; width: 50%; }
        .order-info { float: right; width: 45%; text-align: right; }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 15px;
            border-bottom: 2px solid #dee2e6;
            text-align: left;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            vertical-align: top;
        }
        .text-right { text-align: right; }

        /* Totals */
        .totals-section {
            float: right;
            width: 30%;
            margin-top: 20px;
        }
        .total-row {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .grand-total {
            background-color: #3498db;
            color: white;
            padding: 15px;
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 4px;
        }

        /* Footer */
        .footer {
            margin-top: 100px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="invoice-header">
        <div class="brand-section">
            <h1>INVOICE</h1>
            <p>SUNIVIL INVENTORY</p>
            <p>livinusb230@gmail.com</p>
        </div>
        <div class="status-section">
            <h2>#{{ $order->id }}</h2>
            <p>Date: {{ date('F d, Y') }}</p>
            <p>Status: <strong>PAID</strong></p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="info-container">
        <div class="bill-to">
            <p><strong>BILL TO:</strong></p>
            <h2>{{ $customerName }}</h2>
            <p>{{ $customerEmail }}</p>
            <p>{{ $shippingAddress }}</p>
        </div>
        <div class="order-info">
            <p><strong>OUR DETAILS:</strong></p>
            <p>1385 POSTA TOWN</p>
            <p>Tanzania</p>
            <p>+255 763 240 0851</p>
        </div>
        <div class="clear"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>
                    <strong>{{ $item->product->name ?? 'Product Not Found' }}</strong>
                </td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">${{ number_format($item->price, 2) }}</td>
                <td class="text-right">${{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals-section">
        <div class="total-row">
            <span style="float:left">Subtotal:</span>
            <span style="float:right">${{ number_format($order->total_amount, 2) }}</span>
            <div class="clear"></div>
        </div>
        <div class="grand-total">
            Total: ${{ number_format($order->total_amount, 2) }}
        </div>
    </div>
    <div class="clear"></div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer-generated document. No signature required.</p>
    </div>

</body>
</html>