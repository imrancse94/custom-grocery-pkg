<!DOCTYPE html>
<html>
<head>
    <title>Pre-order Confirmation</title>
</head>
<body>
<p>Dear {{ $preOrder->name }},</p>
<p>Thank you for your pre-order. Here are the details:</p>
<ul>
    <li>Name: {{ $preOrder->name }}</li>
    <li>Email: {{ $preOrder->email }}</li>
    <li>Product: {{ $preOrder->product->name }}</li>
    <li>Phone: {{ $preOrder->phone }}</li>
</ul>
<p>Thank you for choosing us!</p>
</body>
</html>
