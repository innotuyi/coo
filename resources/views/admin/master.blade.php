<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    @notifyCss
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>COTAVOGA MANAGMENT SYSTEM</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <!-- Google fonts - Popppins for copy-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;display=swap" rel="stylesheet">
    <!-- Prism Syntax Highlighting-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/prismjs/plugins/toolbar/prism-toolbar.css">
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/prismjs/themes/prism-okaidia.css">
    <!-- The Main Theme stylesheet (Contains also Bootstrap CSS)-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/css/style.default.63c85ff9.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/css/custom.0a822280.css">
    <style>
        /* Custom styles */
        .custom-small-img {
            width: 80px;
            height: auto;
        }

        @keyframes fadeInWords {
            0% {
                opacity: 0;
                transform: translateX(0);
            }

            25%, 50%, 75%, 100% {
                opacity: 1;
                transform: translateX(0);
                color: rgb(15, 75, 105);
            }
        }

        .animated-text {
            white-space: nowrap;
            overflow: hidden;
        }

        .animated-text span {
            display: inline-block;
            opacity: 0;
            animation: fadeInWords 5s linear infinite;
        }

        .notify {
            z-index: 9999;
            position: fixed;
            top: 0;
            right: 0;
            margin: 10px;
            /* Ensure it's visible and not hidden */
        }

        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }

        .loader {
            width: 100%;
            height: 100%;
            position: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(51, 51, 51, 0.8);
            z-index: 99999;
        }

        body {
        }
    </style>
</head>

<body>
    <div class="loader">
        <img src="{{ asset('assests/image/puff.svg') }}" alt="">
    </div>

    <!-- Notification Component -->
    @include('notify::components.notify')

    <!-- Navbar -->
    @include('admin.partials.header')

    <div class="d-flex align-items-stretch">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <div class="page-holder bg-gray-100">
            <div class="container-fluid mb-xxl-5 flex-grow-1 h-75 px-lg-4 px-xl-5">
                @yield('content')
            </div>
        </div>
    </div>

 <!-- Footer -->
 {{-- <footer class="text-center text-white w-100 bg-secondary">
    <div class="container p-2">
        <div class="row">
            <!-- Add some content, such as links or social icons -->
          
            <div class="col-lg-6 offset-md-2">
                <ul class="list-inline">
                    <li class="list-inline-item mx-3">
                        <a href="#" class="text-white-50"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li class="list-inline-item mx-3">
                        <a href="#" class="text-white-50"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li class="list-inline-item mx-3">
                        <a href="#" class="text-white-50"><i class="fab fa-linkedin-in"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="text-center p-3">
        <span>&copy; 2024 COTAVOGA Management System | All Rights Reserved</span>
    </div>
</footer> --}}



    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/simple-datatables/umd/simple-datatables.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/chart.js/Chart.min.js"></script>
    <script src="js/charts-defaults.8a5fcd99.js"></script>
    <script src="js/index-default.50a9efee.js"></script>
    <script src="https://kit.fontawesome.com/5c95e5cc68.js" crossorigin="anonymous"></script>
    <script src="js/theme.87f0a411.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/prismjs/prism.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/bubbly/1-3-2/vendor/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>

    <x-notify::notify />
    @notifyJs

    <script>
        $(function() {
            setTimeout(() => {
                $('.loader').fadeOut(30); // Adjust the fade-out time
            }, 150); // Initial delay
        });
    </script>

    @stack('yourJsCode')

   <script>
    document.getElementById('sidebar-toggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('open');
    });
   </script>
    
</body>

</html>
