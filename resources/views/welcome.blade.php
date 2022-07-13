<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OPMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: white;
            position: fixed;
            top: 20%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            left: 50%;
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
        }


        .bg-gr {
            background: #087830;
        }

        .wel-logo {
            width: 150px;
        }

        .wel-btn {
            border-radius: 10px;
            background-color: white;
            border: 2px solid #73AD21;
            width: 250px;
            height: 40px;
            color: #087830;
            background: white;
            outline: none
        }

        .wel-btn:hover {
            background: #B4E7BF;
            color: black;
            border: 2px solid #73AD21;
        }

        .wel-label {
            text-align: center;
            color: white;
            font-weight: 300;
            font-size: 18px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .wel-reg {
            color: white;
            text-decoration: underline;
        }

        .wel-reg:hover {
            color: #B4E7BF;
        }
    </style>
</head>

<body class="antialiased bg-gr">

    <center>
        <div class="welcome">
            <div class="">
                <img class="wel-logo" src="./images/white_w_txt.svg" alt="logo">
            </div>

            <div class="wel-label">
                <label>
                    WELCOME TO ABC'S <br>
                    ONLINE PROPERTY MANAGEMENT SYSTEM
                </label>
            </div>
            @if (Route::has('login'))
            @auth
            <a href="{{ route('login') }}">
                <button href="{{ route('login') }}" class="btn wel-btn mb-3">
                    HOME
                </button></a>
            @else
            <div>
                <a href="{{ route('login') }}">
                    <button href="{{ route('login') }}" class="wel-btn">
                        Login
                    </button></a>
                <br>
                @if (Route::has('register'))
                <label class="mt-3">
                    <a class="wel-reg" href="{{ route('register') }}"> Register a new account</a>
                </label>
                @endif
            </div>
            @endauth
            @endif

        </div>
    </center>
</body>

</html>