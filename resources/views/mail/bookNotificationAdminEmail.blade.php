<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>
<div>
    <p>Order Details Notification</p>
    <p>Order ID: {{ $book->id }}</p>
    <p>Order User Name: {{ $book->user_name }}</p>
    <p>Order User Email: {{ $book->user_email }}</p>
    <p>Order Slots: {{ $book->slots_booked }}</p>
    <p>Order Activity Name: {{ $book->activity->name }}</p>
    <p>Order Activity Location: {{ $book->activity->location }}</p>
    <p>Order Activity Price: {{ $book->activity->price }}</p>
</div>
</body>
</html>
