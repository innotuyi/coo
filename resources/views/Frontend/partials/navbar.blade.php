<div class="border-bottom shadow-sm">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-center py-3 bg-secondary ">
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <div class="logo p-3">
                    <!-- Add your logo image or text here -->
                    <a href="#"><img src="{{url('assests/image/logo-cooperative.jpg')}}" alt="Logo"
                            class="img-fluid"></a>
                </div>
            </div>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12">
                <!-- Navigation -->
                <div class="navigation">
                    <ul class="nav justify-content-end gap-3 fw-bold">
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Mission and vision</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">About Us</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .logo img {
        max-width: 100px;
        /* Adjust the size of your logo */
    }

    .nav-link {
        color: #fff !important;
        /* Dark color for nav links */
        transition: color 0.3s;
    }

    .nav-link:hover {
        color: #007bff !important;
        /* Blue color on hover */
    }

    .nav-item {
        position: relative;
    }

    .nav-item::after {
        content: '';
        display: block;
        width: 0;
        height: 8px;
        background: #007bff;
        transition: width 0.3s;
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
    }

    .nav-item:hover::after {
        width: 100%;
    }

    .bg-secondary {

        background-color: #054D6F !important;
    }
</style>
