<header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top pl-30">
        <!-- Sidebar toggle button-->
        <div>
            <ul class="nav">
                <li class="btn-group nav-item">
                    <a href="#" class="waves-effect waves-light nav-link rounded svg-bt-icon" data-toggle="push-menu"
                        role="button">
                        <i class="nav-link-icon mdi mdi-menu"></i>
                    </a>
                </li>
                <li class="btn-group nav-item">
                    <a href="#" data-provide="fullscreen"
                        class="waves-effect waves-light nav-link rounded svg-bt-icon" title="Full Screen">
                        <i class="nav-link-icon mdi mdi-crop-free"></i>
                    </a>
                </li>
                <li class="btn-group nav-item d-none d-xl-inline-block">
                    <a href="#" class="waves-effect waves-light nav-link rounded svg-bt-icon" title="">
                        <i class="ti-check-box"></i>
                    </a>
                </li>
                <li class="btn-group nav-item d-none d-xl-inline-block">
                    <a href="{{ route('calender.view') }}" class="waves-effect waves-light nav-link rounded svg-bt-icon"
                        title="">
                        <i class="ti-calendar"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">
                <!-- full Screen -->
                <li class="search-bar">
                    <div class="lookup lookup-circle lookup-right">
                        <input type="text" name="s">
                    </div>
                </li>
                <!-- Notifications -->

                <li class="dropdown notifications-menu">
                    <a href="#" class="waves-effect waves-light rounded dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" v-pre title="Notifications">

                        <i class="ti-bell"></i>
                        <span
                            class="badge badge-light bg-success badge-xs">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </a>

                    <ul class="dropdown-menu animated bounceIn">
                        <li class="header">
                            <div class="p-20">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">Notifications</h4>
                                    </div>
                                    <div>
                                        <a href="#" class="text-danger">Clear All</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @if (auth()->user()->unreadNotifications)
                            <li class="d-flex justify-content-end mx-1 my-2">
                                <a href="{{ route('mark-as-read') }}" class="text-secondary btn btn-success btn-sm">Mark All as
                                    Read</a>
                            </li>
                        @endif

                        @foreach (auth()->user()->unreadNotifications as $notification)
                            <a href="#" class="text-success">
                                <li class="p-1 text-success"> {{ $notification->data['data'] }}</li>
                            </a>
                        @endforeach
                        @foreach (auth()->user()->readNotifications as $notification)
                            <a href="#" class="text-secondary">
                                <li class="p-1 text-secondary"> {{ $notification->data['data'] }}</li>
                            </a>
                        @endforeach
                    </ul>
                </li>





                {{-- Ensure that the image can be accessed from any page --}}
                @php
                $user = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->first();
            @endphp
                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#" class="waves-effect waves-light rounded dropdown-toggle p-0"
                        data-toggle="dropdown" title="User">

                        <img src="{{ !empty($user->image) ? url('upload/user_images/' . $user->image) : url('upload/no_image.jpg') }}"
                            alt="">

                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <li class="user-body">
                            <a class="dropdown-item" href="{{ route('profile.view') }}"><i
                                    class="ti-user text-muted mr-2"></i> Profile</a>

                            <a class="dropdown-item" href="#"><i class="ti-wallet text-muted mr-2"></i> My
                                Wallet</a>
                            <a class="dropdown-item" href="#"><i class="ti-settings text-muted mr-2"></i>
                                Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                    class="ti-lock text-muted mr-2"></i> Logout</a>

                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar" title="Setting" class="waves-effect waves-light">
                        <i class="ti-settings"></i>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</header>
