<!DOCTYPE html>
<html>
<head>
    <title>Ticket Coach Website</title>
</head>
<body>
    <h1>Hello {{$user->name}}</h1>
    <h2>We are pleased to welcome you to my Ticket Coach Website</h2>
    <h2>Enjoy your time with the most reasonable ticket for your trip at 
        <a href="{{route('auth.login')}}">Ticket Coach Website</a>
    </h2>   
    <p>Thank you so much !</p>
</body>
</html> 