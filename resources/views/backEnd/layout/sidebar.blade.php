<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="text-center my-2">
        {{--<a href="{{route('admin.dashboard')}}" class="logo-dark">
            <img style="width: 200px; aspect-ratio:2/3 " src="{{asset($web_setting->header_logo)}}" class="logo-sm" alt="logo sm">
            <img style="width: 200px; aspect-ratio:2/3 " src="{{asset($web_setting->header_logo)}}" class="logo-lg" alt="logo dark">
        </a>

        <a href="{{route('admin.dashboard')}}" class="logo-light">
            <img style="width: 200px; aspect-ratio:2/3 " src="{{asset($web_setting->header_logo)}}" class="logo-sm" alt="logo sm">
            <img style="width: 200px; aspect-ratio:2/3 " src="{{asset($web_setting->header_logo)}}" class="logo-lg" alt="logo light">
        </a>--}}
        <a class="fw-bold text-success" href="{{route('admin.dashboard')}}" style="font-size: 25px">
            {{$web_setting->company_name}}
        </a>
    </div>
    <hr>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <i class="ri-menu-2-line fs-24 button-sm-hover-icon"></i>
    </button>

    <div class="scrollbar" data-simplebar>

        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">Menu</li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                    <span class="nav-icon"><i class="ri-dashboard-2-line"></i></span>
                    <span class="nav-text"> Dashboard</span>
                </a>
                <div class="collapse" id="sidebarDashboards">
                    <ul class="nav sub-navbar-nav">
                        @if (auth()->user()->can('dashboard'))
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.dashboard')}}">Dashboard</a>
                        </li>
                        @endif
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="#">Finance</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-title">Product Module</li>
            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarProduct" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuthentication">
                    <span class="nav-icon"><i class="ri-product-hunt-line"></i></span>
                    <span class="nav-text"> Product Module </span>
                </a>
                <div class="collapse" id="sidebarProduct">
                    <ul class="nav sub-navbar-nav">
{{--                        @if (auth()->user()->can('role.permission'))--}}
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{route('admin.product.index')}}">Product</a>
                            </li>
{{--                        @endif--}}
{{--                        @if (auth()->user()->can('reset.password'))--}}
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{route('admin.category.index')}}">Category</a>
                            </li>
{{--                        @endif--}}
{{--                        @if (auth()->user()->can('reset.password'))--}}
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{route('admin.brand.index')}}">Brand</a>
                            </li>
{{--                        @endif--}}

                    </ul>
                </div>
            </li>

            <li class="menu-title">User Module</li>

            @if (auth()->user()->can('role.permission') || auth()->user()->can('reset.password'))
            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarAuthentication" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuthentication">
                    <span class="nav-icon"><i class="ri-lock-password-line"></i></span>
                    <span class="nav-text"> Authentication </span>
                </a>
                <div class="collapse" id="sidebarAuthentication">
                    <ul class="nav sub-navbar-nav">
                        @if (auth()->user()->can('role.permission'))
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.role.permission')}}">Role & Permission</a>
                        </li>
                        @endif
                        @if (auth()->user()->can('reset.password'))
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.reset.password')}}">Reset Password</a>
                        </li>
                        @endif

                    </ul>
                </div>
            </li>
            @endif
            @if (auth()->user()->can('setting'))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.setting')}}">
                    <span class="nav-icon">
                        <i class="ri-settings-2-fill"></i>
                    </span>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
            @endif
            @if (auth()->user()->can('user.list'))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.user.index')}}">
                    <span class="nav-icon">
                        <i class="ri-user-2-fill"></i>
                    </span>
                    <span class="nav-text">Users</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>
