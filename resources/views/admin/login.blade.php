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
    <title>Login | Social Network</title>
    <link href="{{ asset('/public/admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/admin/assets/css/auth.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">

                    @if (session()->has("error"))
                        <div class="alert alert-danger">
                            {{ session()->pull("error") }}
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/admin/login') }}">
                        
                        {{ csrf_field() }}

                        <div class="form-group text-left">
                            <label for="email">Email adress</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required />
                        </div>
                        
                        <div class="form-group text-left">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required />
                        </div>

                        <button type="submit" class="btn btn-primary shadow-2 mb-4">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/public/admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/public/admin/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>