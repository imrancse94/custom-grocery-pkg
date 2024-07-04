<!DOCTYPE html>
<html>
<head>
    <title>New Pre-order Notification</title>
</head>
<body>
<p>Dear Admin,</p>
<p>A new pre-order has been submitted. Here are the details:</p>
<ul>
    <li>Name: {{ $preOrder->name }}</li>
    <li>Email: {{ $preOrder->email }}</li>
    <li>Product: {{ $preOrder->product->name }}</li>
    <li>Phone: {{ $preOrder->phone }}</li>
</ul>
<p>Please review the pre-order at your earliest convenience.</p>
</body>
</html>
