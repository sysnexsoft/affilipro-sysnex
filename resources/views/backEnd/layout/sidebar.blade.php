<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="text-center my-2">
        <a class="fw-bold text-success" href="{{route('admin.dashboard')}}" style="font-size: 25px">
            {{$web_setting->company_name}}
        </a>
    </div>
    <hr>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <i class="ri-menu-2-line fs-24 button-sm-hover-icon"></i>
    </button>

    <!-- START: Sidebar Menu Search -->
    <div class="px-3 mb-2 search-box">
        <div class="position-relative">
            <input type="text" id="menuSearch" class="form-control form-control-sm bg-light border-light text-dark" placeholder="Search menu..." style="padding-left: 30px;">
            <i class="ri-search-line position-absolute top-50 translate-middle-y text-muted" style="left: 10px;"></i>
        </div>
    </div>
    <!-- END: Sidebar Menu Search -->

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

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarProduct" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduct">
                    <span class="nav-icon"><i class="ri-product-hunt-line"></i></span>
                    <span class="nav-text"> Product Catalog </span>
                </a>
                <div class="collapse" id="sidebarProduct">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.category.index')}}">Categories</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.brand.index')}}">Brands</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.product.index')}}">All Products</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.compare-fields.index')}}">Comparison Fields</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarCMS" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCMS">
                    <span class="nav-icon"><i class="ri-bubble-chart-line"></i></span>
                    <span class="nav-text"> Content Management </span>
                </a>
                <div class="collapse" id="sidebarCMS">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.cms.reviews.index')}}">Product Reviews</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.blogs-categories.index')}}">Blog Category</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.blogs.index')}}">Blog Posts</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.product.index')}}">Review & Blog Comments</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAnalytics">
                    <span class="nav-icon"><i class="ri-pie-chart-line"></i></span>
                    <span class="nav-text"> Click Analytics Logs </span>
                </a>
                <div class="collapse" id="sidebarAnalytics">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.logs.clicks')}}">Real-time Traffic Logs</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.logs.reports')}}">Performance Reports</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.setting')}}">
                    <span class="nav-icon">
                        <i class="ri-message-3-line"></i>&nbsp;
                        <span class="nav-text fs-5 ms-1">Messages </span>
                    </span>
                    <span class="badge bg-primary">0</span>
                </a>
            </li>

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

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarSetting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSetting">
                    <span class="nav-icon"><i class="ri-settings-4-line"></i></span>
                    <span class="nav-text"> System Settings </span>
                </a>
                <div class="collapse" id="sidebarSetting">
                    <ul class="nav sub-navbar-nav">
                        @if (auth()->user()->can('setting'))
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{route('admin.setting')}}">General Settings</a>
                            </li>
                        @endif
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.brand.index')}}">Email Configuration</a>
                        </li>
                    </ul>
                </div>
            </li>

            @if (auth()->user()->can('setting'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.setting')}}">
                        <span class="nav-icon"><i class="ri-settings-2-fill"></i></span>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->can('user.list'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.user.index')}}">
                        <span class="nav-icon"><i class="ri-user-2-fill"></i></span>
                        <span class="nav-text">Users</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>

<!-- JavaScript for Live Menu Filtering -->
<script>
    document.getElementById('menuSearch').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let navItems = document.querySelectorAll('#navbar-nav .nav-item');

        navItems.forEach(function (item) {
            let parentLink = item.querySelector('.nav-link .nav-text').textContent.toLowerCase();
            let subLinks = item.querySelectorAll('.sub-nav-link');
            let matchFound = false;

            // চেক করুন প্যারেন্ট মেনুর নামের সাথে মেলে কিনা
            if (parentLink.includes(filter)) {
                matchFound = true;
            }

            // সাব-মেনুগুলোর সাথে চেক করুন
            subLinks.forEach(function (subLink) {
                if (subLink.textContent.toLowerCase().includes(filter)) {
                    matchFound = true;
                    // যদি সাব-মেনু মেলে, প্যারেন্ট ড্রপডাউনটি ওপেন করুন
                    let collapseEl = item.querySelector('.collapse');
                    if (collapseEl && filter !== '') {
                        collapseEl.classList.add('show');
                    }
                }
            });

            // যদি কোনো ম্যাচ পাওয়া যায় তবে দেখান, অন্যথায় হাইড করুন
            if (matchFound) {
                item.style.display = "";
            } else {
                item.style.display = "none";
                let collapseEl = item.querySelector('.collapse');
                if (collapseEl) {
                    collapseEl.classList.remove('show');
                }
            }

            // ইনপুট একদম খালি হয়ে গেলে সব ড্রপডাউন আগের অবস্থায় ফিরিয়ে আনুন
            if (filter === '') {
                let collapseEl = item.querySelector('.collapse');
                if (collapseEl) {
                    collapseEl.classList.remove('show');
                }
            }
        });
    });
</script>
