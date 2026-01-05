<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
        <h1 style="color: #dc3545; margin: 0;">⚠️ Low Stock Alert</h1>
    </div>

    <div style="background-color: #fff; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px;">
        <p>Hello Admin,</p>

        @if($products->count() === 1)
            <p>The following product is running low on stock:</p>
        @else
            <p>The following {{ $products->count() }} products are running low on stock:</p>
        @endif

        @foreach($products as $product)
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #dc3545;">
                <h2 style="margin: 0 0 10px 0; color: #333;">{{ $product->name }}</h2>
                <p style="margin: 5px 0;"><strong>Current Stock:</strong> <span style="color: #dc3545; font-weight: bold;">{{ $product->stock_quantity }}</span> units</p>
                <p style="margin: 5px 0;"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            </div>
        @endforeach

        <p style="color: #dc3545; font-weight: bold;">Please restock {{ $products->count() === 1 ? 'this product' : 'these products' }} as soon as possible.</p>

        <p style="margin-top: 30px;">
            Best regards,<br>
            E-commerce Demo System
        </p>
    </div>

    <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; text-align: center; color: #6c757d; font-size: 12px;">
        <p style="margin: 0;">This is an automated notification from the E-commerce Demo Application.</p>
    </div>
</body>
</html>

