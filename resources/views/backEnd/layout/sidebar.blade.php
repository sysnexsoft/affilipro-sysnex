<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="text-center my-3">
        <a class="fw-bold text-success text-decoration-none" href="{{route('admin.dashboard')}}" style="font-size: 22px; letter-spacing: 0.5px;">
            {{$web_setting->company_name}}
        </a>
    </div>
    <hr class="text-muted opacity-25">

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <i class="ri-menu-2-line fs-24 button-sm-hover-icon"></i>
    </button>

    <!-- START: Sidebar Menu Search -->
    <div class="px-3 mb-3 search-box">
        <div class="position-relative">
            <input type="text" id="menuSearch" class="form-control form-control-sm bg-light border-light text-dark" placeholder="Search menu..." style="padding-left: 30px;">
            <i class="ri-search-line position-absolute top-50 translate-middle-y text-muted" style="left: 10px;"></i>
        </div>
    </div>
    <!-- END: Sidebar Menu Search -->

    <div class="scrollbar" data-simplebar  style="padding-bottom: 100px">
        <ul class="navbar-nav" id="navbar-nav">

            <!-- CORE DIVISION -->
            <li class="menu-title text-uppercase font-size-11 fw-bold text-muted">Core</li>

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}" href="{{route('admin.dashboard')}}">
                    <span class="nav-icon"><i class="ri-dashboard-2-line"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Finance (Brought out of dropdown for quick access) -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/finance*') ? 'active' : '' }}" href="#">
                    <span class="nav-icon"><i class="ri-money-dollar-box-line"></i></span>
                    <span class="nav-text">Finance Control</span>
                </a>
            </li>

            <!-- Messages -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ request()->is('admin/setting*') ? 'active' : '' }}" href="{{route('admin.setting')}}">
                    <div class="d-flex align-items-center justify-content-between ">
                        <span class="nav-icon"><i class="ri-message-3-line"></i></span>
                        <span class="nav-text ms-2">Messages</span>
                    </div>
                    <span class="badge bg-danger rounded-pill">0</span>
                </a>
            </li>


            <!-- SHOP MANAGEMENT -->
            <li class="menu-title text-uppercase font-size-11 fw-bold text-muted mt-1">Shop Management</li>

            <!-- Product Catalog -->
            <li class="nav-item">
                <a class="nav-link menu-arrow {{ request()->is(['admin/product*', 'admin/category*', 'admin/brand*', 'admin/products/*']) ? 'active' : '' }}" href="#sidebarProduct" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduct">
                    <span class="nav-icon"><i class="ri-store-2-line"></i></span>
                    <span class="nav-text">Product Catalog</span>
                </a>
                <div class="collapse {{ request()->is(['admin/product*', 'admin/category*', 'admin/brand*', 'admin/products/*']) ? 'show' : '' }}" id="sidebarProduct">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/product*') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.product.index')}}">All Products</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/category*') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.category.index')}}">Categories</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/brand*') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.brand.index')}}">Brands</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/products/compare-fields*') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.compare-fields.index')}}">Comparison Fields</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Reviews (Brought out for direct content monitoring) -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/cms/reviews*') ? 'active' : '' }}" href="{{route('admin.cms.reviews.index')}}">
                    <span class="nav-icon"><i class="ri-star-smile-line"></i></span>
                    <span class="nav-text">Product Reviews</span>
                </a>
            </li>


            <!-- CONTENT & MARKETING -->
            <li class="menu-title text-uppercase font-size-11 fw-bold text-muted mt-1">Content & Promotion</li>

            <!-- Blogs Management -->
            <li class="nav-item">
                <a class="nav-link menu-arrow {{ request()->is(['admin/blogs-categories*', 'admin/blogs*']) ? 'active' : '' }}" href="#sidebarBlogs" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBlogs">
                    <span class="nav-icon"><i class="ri-article-line"></i></span>
                    <span class="nav-text">Blog Engine</span>
                </a>
                <div class="collapse {{ request()->is(['admin/blogs-categories*', 'admin/blogs*']) ? 'show' : '' }}" id="sidebarBlogs">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/blogs/*') || request()->is('admin/blogs') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.blogs.index')}}">Blog Posts</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/blogs-categories*') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.blogs-categories.index')}}">Blog Categories</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- SEO Management -->
            @if (auth()->user()->can('seo.list'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/seo*') ? 'active' : '' }}" href="{{route('admin.seo.index')}}">
                        <span class="nav-icon"><i class="ri-search-eye-line"></i></span>
                        <span class="nav-text">SEO Management</span>
                    </a>
                </li>
            @endif


        <!-- BUSINESS INSIGHTS -->
            <li class="menu-title text-uppercase font-size-11 fw-bold text-muted mt-1">Analytics</li>

            <!-- Traffic Logs & Performance -->
            <li class="nav-item">
                <a class="nav-link menu-arrow {{ request()->is(['admin/logs/*']) ? 'active' : '' }}" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAnalytics">
                    <span class="nav-icon"><i class="ri-bar-chart-grouped-line"></i></span>
                    <span class="nav-text">Traffic Logs</span>
                </a>
                <div class="collapse {{ request()->is(['admin/logs/*']) ? 'show' : '' }}" id="sidebarAnalytics">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/logs/clicks') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.logs.clicks')}}">Real-time Traffic</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/logs/reports') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.logs.reports')}}">Performance Reports</a>
                        </li>
                    </ul>
                </div>
            </li>


            <!-- SETTINGS & SECURITY -->
            <li class="menu-title text-uppercase font-size-11 fw-bold text-muted mt-1">System Controls</li>

            <!-- User Management -->
            @if (auth()->user()->can('user.list'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{route('admin.user.index')}}">
                        <span class="nav-icon"><i class="ri-user-settings-line"></i></span>
                        <span class="nav-text">User Directory</span>
                    </a>
                </li>
            @endif

            <!-- User Management -->
{{--            @if (auth()->user()->can('user.list'))--}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/admin/subscribers*') ? 'active' : '' }}" href="{{route('admin.subscribers.index')}}">
                        <span class="nav-icon"><i class="ri-user-2-fill"></i></span>
                        <span class="nav-text">Subscriber</span>
                    </a>
                </li>
{{--            @endif--}}

        <!-- Security & Access -->
            @if (auth()->user()->can('role.permission') || auth()->user()->can('reset.password'))
                <li class="nav-item">
                    <a class="nav-link menu-arrow {{ request()->is(['admin/role*', 'admin/reset*']) ? 'active' : '' }}" href="#sidebarAuthentication" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuthentication">
                        <span class="nav-icon"><i class="ri-shield-keyhole-line"></i></span>
                        <span class="nav-text">Access Control</span>
                    </a>
                    <div class="collapse {{ request()->is(['admin/role*', 'admin/reset*']) ? 'show' : '' }}" id="sidebarAuthentication">
                        <ul class="nav sub-navbar-nav">
                            @if (auth()->user()->can('role.permission'))
                                <li class="sub-nav-item">
                                    <a class="sub-nav-link {{ request()->is('admin/role*') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.role.permission')}}">Roles & Permissions</a>
                                </li>
                            @endif
                            @if (auth()->user()->can('reset.password'))
                                <li class="sub-nav-item">
                                    <a class="sub-nav-link {{ request()->is('admin/reset*') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.reset.password')}}">Reset Password</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

        <!-- Configuration Settings -->
            <li class="nav-item">
                <a class="nav-link menu-arrow {{ request()->is(['admin/setting*', 'admin/currency*', 'admin/page-setting*']) ? 'active' : '' }}" href="#sidebarSetting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSetting">
                    <span class="nav-icon"><i class="ri-settings-5-line"></i></span>
                    <span class="nav-text">Settings</span>
                </a>
                <div class="collapse {{ request()->is(['admin/setting*', 'admin/currency*', 'admin/page-setting*']) ? 'show' : '' }}" id="sidebarSetting">
                    <ul class="nav sub-navbar-nav">
                        @if (auth()->user()->can('setting'))
                            <li class="sub-nav-item">
                                <a class="sub-nav-link {{ request()->is('admin/setting') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.setting')}}">General Settings</a>
                            </li>
                        @endif

                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->is('admin/page-settings') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.page_settings.index')}}">Page Settings</a>
                        </li>

                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{route('admin.brand.index')}}">Email Configuration</a>
                        </li>
                        @can('currency.list')
                            <li class="sub-nav-item">
                                <a class="sub-nav-link {{ request()->is('admin/currency*') ? 'active text-dark bg-info-subtle' : ''}}" href="{{route('admin.currency.index')}}">Currency Settings</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>

<!-- JavaScript for Live Menu Filtering (Enhanced to auto-expand categories properly on filter) -->
<script>
    document.getElementById('menuSearch').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let navItems = document.querySelectorAll('#navbar-nav .nav-item');
        let titles = document.querySelectorAll('#navbar-nav .menu-title');

        navItems.forEach(function (item) {
            let parentTextEl = item.querySelector('.nav-link .nav-text');
            let parentLink = parentTextEl ? parentTextEl.textContent.toLowerCase() : '';
            let subLinks = item.querySelectorAll('.sub-nav-link');
            let matchFound = false;

            if (parentLink.includes(filter)) {
                matchFound = true;
            }

            subLinks.forEach(function (subLink) {
                if (subLink.textContent.toLowerCase().includes(filter)) {
                    matchFound = true;
                    let collapseEl = item.querySelector('.collapse');
                    if (collapseEl && filter !== '') {
                        collapseEl.classList.add('show');
                    }
                }
            });

            if (matchFound) {
                item.style.display = "";
            } else {
                item.style.display = "none";
                let collapseEl = item.querySelector('.collapse');
                if (collapseEl) {
                    collapseEl.classList.remove('show');
                }
            }
        });

        // Hide section titles if all items under it are hidden
        if (filter !== '') {
            titles.forEach(t => t.style.display = "none");
        } else {
            titles.forEach(t => t.style.display = "");
            // Collapse all menus back to original active states on empty filter
            navItems.forEach(function (item) {
                let collapseEl = item.querySelector('.collapse');
                if (collapseEl && !item.querySelector('.nav-link').classList.contains('active')) {
                    collapseEl.classList.remove('show');
                }
            });
        }
    });
</script>
