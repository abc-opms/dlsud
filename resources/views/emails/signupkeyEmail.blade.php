<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Lato", sans-serif
        }

        .w3-bar,
        h1,
        button {
            font-family: "Montserrat", sans-serif
        }

        .fa-anchor,
        .fa-coffee {
            font-size: 200px
        }

        .bg {
            background-image: url('b1.jpg');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .bg-text {
            background: whitesmoke;
            opacity: 0.5;
        }

        .button {
            background: #087830;
            color: white;
        }
    </style>
</head>

<body>


    <!-- Header -->
    <header class="w3-container w3-center bg" style="padding:128px 16px; background:#627E6C;">

        <h1 class="w3-margin w3-jumbo bg-text">DLSUD OPMS</h1>
        <button class="w3-button w3-padding-large w3-large w3-margin-top button">
            <a href="http://127.0.0.1:8000/register">
                Register
            </a>
        </button>
    </header>

    <!-- First Grid -->
    <div class="w6-row-padding w3-padding-64 w3-container">
        <div class="w3-content">
            <div class="w3-twothird">
                <h1>Welcome {{$role}}!</h1>
                <h5 class="w3-padding-32">Welcome to DLDU-D OPMS Registration System.</h5>

                <p class="w3-text-grey">This email is an auto-generated email. Sign Up Key is sent to you in order to fully access the OPMS as a/an
                    {{$role}}
                    for DLSU-D New Assets’ Online Property Management System. Please follow the step-by-step instructions below to create you OPMS Account.
                    Other details are also sent to you for your reference.
                </p>

                <label>Step-by-step Instructions for OPMS Registration:</label>
                <ul>
                    <li>Open this <a href="http://127.0.0.1:8000/register">link</a> on your mobile phone or web browser.</li>
                    <li>Click Register new account.</li>
                    <li>Enter the following required information.</li>
                    <li>Enter the Sign Up Key sent on your email. </li>
                    <li>Click Register.</li>
                    <li>Any issues/problems encountered with the registration process, kindly escalate this to the Property Section Office to determine possible solution. </li>
                </ul>
            </div>
        </div>
    </div>
    </div>


    <div class="w3-container w3-center w3-padding-50" style="background: #627E6C;">
        <h1 class="w3-margin w3-xlarge" style="color: black;">Signupkey: {{$skey}}</h1>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-padding-64 w3-center w3-opacity">

    </footer>

    <script>
        // Used to toggle the menu on small screens when clicking on the menu button
        function myFunction() {
            var x = document.getElementById("navDemo");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }
    </script>

</body>

</html>