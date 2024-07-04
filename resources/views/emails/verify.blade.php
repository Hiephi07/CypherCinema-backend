<!DOCTYPE html>
<html>
<head>
    <title>Xác thực email</title>
</head>
<body>
    <h1>Xin chào, {{ $user->name }}</h1>
    <p>Vui lòng nhấn vào liên kết dưới đây để xác thực email của bạn:</p>
    <a href="{{ url('verify', $user->verification_token) }}">Xác thực email</a>
</body>
</html>
