<!doctype html>
<!-- 
* Bootstrap Simple Admin Template
* Version: 2.0
* Author: Alexis Luna
* Copyright 2020 Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel | Social Network</title>
    <link href="{{ asset('/public/admin/assets/vendor/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/admin/assets/vendor/fontawesome/css/solid.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/admin/assets/vendor/fontawesome/css/brands.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/admin/assets/css/master.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/admin/assets/vendor/chartsjs/Chart.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/admin/assets/vendor/flagiconcss/css/flag-icon.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/public/wysiwyg/richtext.min.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('/public/admin/assets/img/bootstraper-logo.png') }}" alt="bootraper logo" class="app-logo">
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="{{ url('/admin') }}"><i class="fas fa-home"></i> Dashboard</a>
                </li>

                <li>
                    <a href="{{ url('/admin/posts/all') }}">
                        <i class="fas fa-file-alt"></i>
                        Posts
                    </a>
                </li>

                <li>
                    <a href="{{ url('/admin/users/all') }}">
                        <i class="fas fa-user"></i>
                        Users
                    </a>
                </li>

                <li>
                    <a href="{{ url('/admin/tickets') }}">
                        <i class="fas fa-ticket-alt"></i>
                        Tickets

                        @if ($unread_tickets > 0)
                            ({{ $unread_tickets }})
                        @endif
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0);" onclick="premiumVersionPopup();">
                        <i class="fas fa-copy"></i>
                        Pages
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0);" onclick="premiumVersionPopup();">
                        <i class="fas fa-users"></i>
                        Groups
                    </a>
                </li>
            </ul>
        </nav>

        <div id="body" class="active">
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="{{ url('/admin/tickets') }}" class="nav-item nav-link text-secondary">
                                    <i class="fas fa-bell"></i>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span>{{ auth()->user()->name }}</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <!-- <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li> -->
                                        <div class="dropdown-divider"></div>
                                        <li><a href="{{ url('/logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="content">
                @yield ("main")
            </div>


        </div>
    </div>

    <script src="{{ asset('/public/admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/public/admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/public/admin/assets/vendor/chartsjs/Chart.min.js') }}"></script>
    <script src="{{ asset('/public/admin/assets/js/dashboard-charts.js') }}"></script>
    <script src="{{ asset('/public/assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/public/admin/assets/js/script.js?v=' . time()) }}"></script>

    <script src="{{ asset('/public/wysiwyg/jquery.richtext.min.js') }}"></script>

</body>

</html>