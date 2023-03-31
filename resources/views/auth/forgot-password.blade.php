<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.ico">

    <title>Mahjong Peoples Relations Management - Forgot Password </title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/skin_color.css') }}">

</head>

<body class="hold-transition theme-light bg-gradient-success">

    <div class="container h-p80">
        <div class="row align-items-center justify-content-md-center h-p100">

            <div class="col-12">
                <div class="row justify-content-center no-gutters">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="content-top-agile p-10">
                            <h2 class="text-white">To Continue</h2>
                            <p class="text-white-50">Input Email</p>
                        </div>
                        <div class="p-30 rounded30 box-shadowed b-2 b-dashed bg-white">

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-4 text-sm text-gray-800">
                                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent text-black"><i
                                                    class="ti-user"></i></span>
                                        </div>
                                        <input type="email" id="email" name="email"
                                            class="form-control pl-15 bg-transparent text-black plc-black"
                                            required="" placeholder="Email" required autofocus
                                            autocomplete="username">
                                    </div>

                                    <div class="flex items-center justify-end mt-4 mb-0 text-white">
                                        <x-button class="btn btn-info btn-rounded ml-9 font-weight-bold text-uppercase">
                                            {{ __('Email Password Reset Link') }}
                                        </x-button>
                                    </div>
                                </div>









                                @if (session('status'))
                                    <div class="mb-4 font-medium text-sm text-green-600">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="{{ asset('backend/js/vendors.min.js') }}"></script>
    <script src="{{ asset('../assets/icons/feather-icons/feather.min.js') }}"></script>


</body>

</html>
