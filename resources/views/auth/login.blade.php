<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.ico">

    <title>Employee Management - Log in </title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/skin_color.css') }}">

</head>

<body class="hold-transition theme-light bg-gradient-success">

    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">

            <div class="col-12">
                <div class="row justify-content-center no-gutters">
                    <div class="col-lg-4 col-md-5 col-12">
                        <div class="content-top-agile p-10">
                            <h2 class="text-white">To Continue</h2>
                            <p class="text-white-50">Login</p>
                        </div>
                        <div class="p-30 rounded30 box-shadowed b-2 b-dashed">

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent text-white"><i
                                                    class="ti-user"></i></span>
                                        </div>
                                        <input type="email" id="email" name="email"
                                            class="form-control pl-15 bg-transparent text-white plc-white" required=""
                                            placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-transparent text-white"><i
                                                    class="ti-lock"></i></span>
                                        </div>
                                        <input type="password" id="password" name="password"
                                            class="form-control pl-15 bg-transparent text-white plc-white" required=""
                                            placeholder="Password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="checkbox text-white">
                                            <input type="checkbox" id="remember_me" name="remember">
                                            <label for="remember_me">Remember Me</label>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6">
                                        <div class="fog-pwd text-right">
                                            <a href="{{ route('password.request') }}" class="text-white hover-info"><i
                                                    class="ion ion-locked"></i> Forgot Password?</a><br>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-info btn-rounded mt-10">SIGN IN</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>

                            <div class="text-center text-white">
                                <p class="mt-20">- Sign With -</p>
                                <p class="gap-items-2 mb-20">
                                    <a class="btn btn-social-icon btn-round btn-outline btn-white mr-md-6"
                                        href="auth/redirect"><i class="fa fa-github mr-md-3">Github</i></a>
                                    <a class="btn btn-social-icon btn-round btn-outline btn-white" href="auth/redirect"><i
                                            class="fa fa-google-plus p-6">Google</i></a>
                                    
                                </p>
                            </div>

                            <div class="text-center">
                                <p class="mt-15 mb-0 text-white">Don't have an account? <a
                                        href="{{ route('register') }}"
                                        class="btn btn-info btn-rounded ml-5 font-weight-bold text-uppercase ">Sign
                                        Up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Vendor JS -->
    <script src="{{ asset('backend/js/vendors.min.js') }}"></script>
    <script src="{{ asset('../assets/icons/feather-icons/feather.min.js') }}"></script>

</body>

</html>



{{-- @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif --}}
