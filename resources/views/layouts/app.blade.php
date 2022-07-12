<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>Social Network</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <meta name="_token" content="{{ csrf_token() }}" />

        <!-- Favicons -->
        <link href="{{ asset('/public/assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('/public/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <!-- Vendor CSS Files -->
        <link href="{{ asset('/public/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/public/assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/public/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/public/assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
        <link href="{{ asset('/public/assets/vendor/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet">
        <!-- <link href="{{ asset('/public/assets/owl.carousel.min.css') }}" rel="stylesheet"> -->
        <link href="{{ asset('/public/assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="{{ asset('/public/assets/css/style.css?v=' . time()) }}" rel="stylesheet">
        <link href="{{ asset('/public/assets/css/main.css?v=' . time()) }}" rel="stylesheet">
        <link href="{{ asset('/public/assets/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="{{ asset('/public/assets/datepicker/jquery.datetimepicker.min.css') }}" />

        <link href="{{ asset('/public/wysiwyg/richtext.min.css') }}" rel="stylesheet" />

        <!-- =======================================================
            * Template Name: Serenity - v2.2.1
            * Template URL: https://bootstrapmade.com/serenity-bootstrap-corporate-template/
            * Author: BootstrapMade.com
            * License: https://bootstrapmade.com/license/
            ======================================================== -->
    </head>
    <body>

        <input type="hidden" id="base-url" value="{{ url('/') }}" />
        <input type="hidden" id="my-id" value="{{ auth()->check() ? auth()->user()->id : 0 }}" />

        <script>
            var baseUrl = "";
            var myId = "";

            baseUrl = document.getElementById("base-url").value;
            myId = document.getElementById("my-id").value;
        </script>

        <style>
            #header {
                background-color: #94c045 !important;
            }
            #header .logo h1 a,
            .nav-menu a {
                color: white !important;
            }
            .drop-down ul li a {
                color: black !important;
            }
        </style>

        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top">
            <div class="container d-flex">
                <div class="logo mr-auto">
                    <h1 class="text-light"><a href="{{ url('/') }}">Social Network</a></h1>
                    <!-- Uncomment below if you prefer to use an image logo -->
                    <!-- <a href="index.html"><img src="{{ asset('/public/assets/img/logo.png') }}" alt="" class="img-fluid"></a>-->
                </div>
                <nav class="nav-menu d-none d-lg-block">
                    <ul>
                        <li class="active"><a href="{{ url('/') }}">Home</a></li>
                        @if (auth()->check())
                            <li class="drop-down">
                                <a href="#">{{ auth()->user()->name }}</a>
                                <ul>
                                    <li><a href="{{ url('/profile') }}">Profile</a></li>
                                    <li><a href="{{ url('/logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ url('/login') }}">
                                Login
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/register') }}">
                                Register
                                </a>
                            </li>
                        @endif

                        <li>
                            <form method="GET" action="{{ url('/search') }}">
                                <input type="search" name="q" class="form-control" placeholder="Search here..." required style="padding-left: 10px;" />
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- .nav-menu -->
            </div>
        </header>
        <!-- End Header -->
        @yield("main")
        <!-- ======= Footer ======= -->
        <footer id="footer">
            <div class="container">
                <div class="copyright">
                    &copy; Copyright <strong><span>Serenity</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/serenity-bootstrap-corporate-template/ -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
        </footer>
        <!-- End Footer -->
        <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
        <!-- Vendor JS Files -->
        <script src="{{ asset('/public/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/public/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/public/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
        <!-- <script src="{{ asset('/public/assets/vendor/php-email-form/validate.js') }}"></script> -->
        <script src="{{ asset('/public/assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('/public/assets/vendor/counterup/counterup.min.js') }}"></script>
        <script src="{{ asset('/public/assets/vendor/venobox/venobox.min.js') }}"></script>
        <!-- <script src="{{ asset('/public/assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script> -->
        <script src="{{ asset('/public/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('/public/assets/vendor/aos/aos.js') }}"></script>
        <!-- Template Main JS File -->
        <script src="{{ asset('/public/assets/js/main.js') }}"></script>
        <script src="{{ asset('/public/assets/js/sweetalert.min.js') }}"></script>

        <script src="{{ asset('/public/assets/datepicker/jquery.datetimepicker.full.min.js') }}"></script>

        <script src="{{ asset('/public/assets/js/socket.io.js') }}"></script>
        <script src="{{ asset('/public/assets/js/notify.js') }}"></script>

        <script src="{{ asset('/public/wysiwyg/jquery.richtext.min.js') }}"></script>

        <script src="{{ asset('/public/assets/js/script.js?v=' . time()) }}"></script>
    </body>
</html>