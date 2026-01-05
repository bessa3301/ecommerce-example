<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #28a745; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
        <h1 style="color: #fff; margin: 0;">📊 Daily Sales Report</h1>
        <p style="color: #fff; margin: 5px 0 0 0;">{{ $salesData['date'] }}</p>
    </div>

    <div style="background-color: #fff; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px;">
        <p>Hello Admin,</p>

        <p>Here's your daily sales report for <strong>{{ $salesData['date'] }}</strong>:</p>

        <!-- Summary Stats -->
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h2 style="margin: 0 0 15px 0; color: #333; border-bottom: 2px solid #dee2e6; padding-bottom: 10px;">Summary</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <p style="margin: 5px 0; color: #6c757d; font-size: 14px;">Total Orders</p>
                    <p style="margin: 0; font-size: 24px; font-weight: bold; color: #333;">{{ $salesData['total_orders'] }}</p>
                </div>
                <div>
                    <p style="margin: 5px 0; color: #6c757d; font-size: 14px;">Total Revenue</p>
                    <p style="margin: 0; font-size: 24px; font-weight: bold; color: #28a745;">${{ number_format($salesData['total_revenue'], 2) }}</p>
                </div>
                <div style="grid-column: 1 / -1;">
                    <p style="margin: 5px 0; color: #6c757d; font-size: 14px;">Total Items Sold</p>
                    <p style="margin: 0; font-size: 24px; font-weight: bold; color: #333;">{{ $salesData['total_items_sold'] }}</p>
                </div>
            </div>
        </div>

        @if(count($salesData['products_sold']) > 0)
        <div style="margin-top: 30px;">
            <h2 style="margin: 0 0 15px 0; color: #333; border-bottom: 2px solid #dee2e6; padding-bottom: 10px;">All Products Sold Today</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Product</th>
                        <th style="padding: 10px; text-align: right; border-bottom: 2px solid #dee2e6;">Quantity</th>
                        <th style="padding: 10px; text-align: right; border-bottom: 2px solid #dee2e6;">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesData['products_sold'] as $product)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">{{ $product['name'] }}</td>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">{{ $product['quantity'] }}</td>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">${{ number_format($product['revenue'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 0; color: #856404;">No sales were recorded today.</p>
        </div>
        @endif

        <p style="margin-top: 30px;">
            Best regards,<br>
            E-commerce Demo System
        </p>
    </div>

    <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; text-align: center; color: #6c757d; font-size: 12px;">
        <p style="margin: 0;">This is an automated daily report from the E-commerce Demo Application.</p>
    </div>
</body>
</html>

