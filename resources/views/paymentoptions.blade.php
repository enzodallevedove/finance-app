<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Your accounts</h1>
    @foreach ($paymentOptions as $paymentOption)
        <h3>{{ $paymentOption->name }}</h3>
    @endforeach
</body>

</html>