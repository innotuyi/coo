<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    {{-- @notifyCss --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Leave Management System">
    <meta name="keywords" content="Leave, Management, HR">
    <title>Leave Management System</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Custom Style CSS -->
    <link href="https://easetemplate.com/free-website-templates/hrms/css/style.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Body and general styling */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Logo styling */
        .logo img {
            max-width: 100px;
            height: auto;
            border-radius: 50%;
            transition: transform 0.3s ease-in-out;
        }

        .logo img:hover {
            transform: scale(1.1);
        }

        .ft-logo img {
            max-width: 200px;
            height: auto;
            border-radius: 50px;
        }

        /* Top navigation styling */
        .navbar {
            background-color: #1e88e5;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            padding: 10px 15px;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffcd39 !important;
        }

        .menu-toggel .dots-icon {
            font-size: 1.5rem;
            color: #fff;
        }

        /* Footer Styling */
        footer {
            background-color: #1e88e5 !important;
            padding: 20px 0;
            color: #fff;
            text-align: center;
        }

        footer a {
            color: #ffcd39;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        /* Cards and buttons */
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .btn-custom {
            background-color: #1e88e5;
            color: white;
            border-radius: 50px;
            padding: 10px 30px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #155a8a;
        }

        /* Notify styling */
        .notify {
            z-index: 9999;
            display: flex;
            justify-content: center;
        }

        /* Footer hover effect */
        .footer-logo img {
            border-radius: 50%;
        }

        /* Custom color for highlights */
        .custom-color {
            color: #1e88e5;
        }
    </style>
</head>

<body>
    {{-- @include('notify::components.notify') --}}

    <!-- Top Header -->
    <div class="menu-toggel">
        <a href="#" id="dots" class="dots-icon"><i class="fa fa-ellipsis-v visible-xs"></i></a>
    </div>

    <!-- Navbar -->
    @include('Frontend.partials.navbar')

    <!-- Slider Section -->
    @yield('content')

    <!-- Footer Section -->
    @include('Frontend.partials.footer')

    <!-- Scripts -->
    <script src="https://easetemplate.com/free-website-templates/hrms/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://easetemplate.com/free-website-templates/hrms/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://easetemplate.com/free-website-templates/hrms/js/menumaker.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://easetemplate.com/free-website-templates/hrms/js/owl.carousel.min.js"></script>

    <script>
        // Event for View Services
        document.querySelector('.view-services').addEventListener('click', function (event) {
            event.preventDefault();
            this.style.display = 'none';
            document.querySelectorAll('.hidden-card').forEach(card => {
                card.style.display = 'block';
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    {{-- @notifyJs --}}
    <script src="https://kit.fontawesome.com/5c95e5cc68.js" crossorigin="anonymous"></script>
</body>

</html>
