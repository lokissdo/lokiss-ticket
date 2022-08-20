<!DOCTYPE html>
<html>

<head>
    <title>Ticket Coach Website</title>
</head>

<body>
    <div>Hello <strong>{{ $data['name'] }}</strong>, </div>
    <div>We are sending you a message to inform you that your payment has been successful. </div>
    @if (isset($data['password']))
        We created an account for you in order that you can see your booking details at our website {{route('login')}}</div>
        <div>- Email: {{ $data['email'] }}</div>
        <div>- Password: {{ $data['password'] }}</div>
        <div style="color:red">*If it's not you, change password at {{route('login')}} to secure your transactions afterwards </div>
    @else
    You can see your booking details at our website {{route('login')}}</div>
    @endif
  
    <div>Hope you are happy with your trip! Thank you for being a valued {{ env('APP_NAME') }} customer</div>
    <div>Enjoy your time with the most reasonable ticket for your trip at
        <a href="{{route('passenger.index')}}">Ticket Coach Website</a>
    </div>
    <p>Thank you so much !</p>
</body>

</html>
