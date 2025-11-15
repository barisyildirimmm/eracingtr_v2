<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>eRacing Türkiye - E-posta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .email-header {
            background-color: #000b18;
            color: #ffffff;
            text-align: center;
            padding: 20px 10px;
        }

        .email-header img {
            max-width: 250px;
        }

        .email-body {
            padding: 20px;
            line-height: 1.6;
        }

        .email-footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666666;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff;
            background-color: #e63946;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }

        .button:hover {
            background-color: #d62839;
        }
    </style>
</head>

<body>
<div class="email-container">
    <!-- Header -->
    <div class="email-header">
        <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo/logo.png?v=2') }}" alt="eRacing Türkiye Logo"></a>
    </div>

    <!-- Body -->
    <div class="email-body">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="email-footer">
        <p>Bu e-posta otomatik olarak gönderilmiştir. Lütfen yanıtlamayın.</p>
        <p>eRacing Türkiye © 2017 - {{ date('Y') }}</p>
    </div>
</div>
</body>

</html>
