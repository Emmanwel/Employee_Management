<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.ico">

    <title>Mahjong Peoples Relations Management - Reset Password </title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/skin_color.css') }}">

</head>

<body class="hold-transition theme-light bg-gradient-success">

    <div class="container h-p80 ">
        <div class="row align-items-center justify-content-md-center h-p100 ">

            <div class="col-12 ">
                <div class="row justify-content-center no-gutters">
                    <div class="col-lg-8 col-md-8 col-12">

                        <div class="p-30 rounded30 box-shadowed b-2 b-dashed bg-white">

                            <div class="mb-4 text-sm text-gray-600">
                                {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </div>

                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                                </div>
                            @endif

                            <div class="mt-4 flex items-center justify-between">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf

                                    <div>
                                        <x-button type="submit"
                                            class="mb-7 btn btn-info btn-rounded ml-9 font-weight-bold ">
                                            {{ __('Resend Verification Email') }}
                                        </x-button>
                                    </div>
                                </form>

                                <div class="m-10">
                                    <a href="{{ route('profile.show') }}"
                                        class=" text-uppercase underline text-sm text-gray-600 hover:text-white-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Edit Profile') }}</a>

                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf

                                        <button type="submit"
                                            class="mt-10 underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2">
                                            {{ __('Log Out') }}
                                        </button>

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

                <script src="{{ asset('backend/js/vendors.min.js') }}"></script>
                <script src="{{ asset('../assets/icons/feather-icons/feather.min.js') }}"></script>


</body>

</html>
