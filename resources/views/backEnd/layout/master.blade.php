<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>{{env('APP_NAME')}} - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template, Real Estate Management Admin Template" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('/')}}Backend/assets/images/favicon.ico">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{asset('/')}}Backend/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{asset('/')}}Backend/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{asset('/')}}Backend/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet"/>
    <!-- Theme Config js (Require in all Page) -->
    <script src="{{asset('/')}}Backend/assets/js/config.min.js"></script>

</head>

<body>

<!-- START Wrapper -->
<div class="wrapper">

    <!-- ========== Topbar Start ========== -->
    @include('backEnd.layout.header')

    <!-- Right Sidebar (Theme Settings) -->
    <div>
        <div class="offcanvas offcanvas-end border-0 rounded-start-4 overflow-hidden" tabindex="-1" id="theme-settings-offcanvas">
            <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
                <h5 class="text-white m-0">Theme Settings</h5>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body p-0">
                <div data-simplebar class="h-100">
                    <div class="p-3 settings-bar">

                        <div>
                            <h5 class="mb-3 font-16 fw-semibold">Color Scheme</h5>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-color-light" value="light">
                                <label class="form-check-label" for="layout-color-light">Light</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-color-dark" value="dark">
                                <label class="form-check-label" for="layout-color-dark">Dark</label>
                            </div>
                        </div>

                        <div>
                            <h5 class="my-3 font-16 fw-semibold">Topbar Color</h5>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-topbar-color" id="topbar-color-light" value="light">
                                <label class="form-check-label" for="topbar-color-light">Light</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-topbar-color" id="topbar-color-dark" value="dark">
                                <label class="form-check-label" for="topbar-color-dark">Dark</label>
                            </div>
                        </div>


                        <div>
                            <h5 class="my-3 font-16 fw-semibold">Menu Color</h5>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-menu-color" id="leftbar-color-light" value="light">
                                <label class="form-check-label" for="leftbar-color-light">
                                    Light
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-menu-color" id="leftbar-color-dark" value="dark">
                                <label class="form-check-label" for="leftbar-color-dark">
                                    Dark
                                </label>
                            </div>
                        </div>

                        <div>
                            <h5 class="my-3 font-16 fw-semibold">Sidebar Size</h5>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-menu-size" id="leftbar-size-default" value="default">
                                <label class="form-check-label" for="leftbar-size-default">
                                    Default
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-menu-size" id="leftbar-size-small" value="condensed">
                                <label class="form-check-label" for="leftbar-size-small">
                                    Condensed
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-menu-size" id="leftbar-hidden" value="hidden">
                                <label class="form-check-label" for="leftbar-hidden">
                                    Hidden
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-menu-size" id="leftbar-size-small-hover-active" value="sm-hover-active">
                                <label class="form-check-label" for="leftbar-size-small-hover-active">
                                    Small Hover Active
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="data-menu-size" id="leftbar-size-small-hover" value="sm-hover">
                                <label class="form-check-label" for="leftbar-size-small-hover">
                                    Small Hover
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="offcanvas-footer border-top p-3 text-center">
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-danger w-100" id="reset-layout">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== Topbar End ========== -->

    <!-- ========== App Menu Start ========== -->
    @include('backEnd.layout.sidebar')
    <!-- ========== App Menu End ========== -->

    <!-- ==================================================== -->
    <!-- Start right Content here -->
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-fluid">

            @yield('body')

        </div>
        <!-- End Container Fluid -->

        <!-- ========== Footer Start ========== -->
        @include('backEnd.layout.footer')
        <!-- ========== Footer End ========== -->

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->

</div>
<!-- END Wrapper -->

<!-- Vendor Javascript (Require in all Page) -->
<script src="{{asset('/')}}Backend/assets/js/jquery.min.js"></script>
<script src="{{asset('/')}}Backend/assets/js/vendor.js"></script>
<!-- App Javascript (Require in all Page) -->
<script src="{{asset('/')}}Backend/assets/js/app.js"></script>

<!-- Vector Map Js -->
<script src="{{asset('/')}}Backend/assets/vendor/jsvectormap/js/jsvectormap.min.js"></script>
<script src="{{asset('/')}}Backend/assets/vendor/jsvectormap/maps/world-merc.js"></script>
<script src="{{asset('/')}}Backend/assets/vendor/jsvectormap/maps/world.js"></script>

<!-- Dashboard Js -->
<script src="{{asset('/')}}Backend/assets/js/pages/dashboard-analytics.js"></script>
<script src="{{asset('/')}}Backend/assets/js/sweetalert.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.min.js"></script>
<script>
    document.getElementById('logout-btn').addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, Logout"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>

@if(session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session("success") }}',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    </script>
@endif
@if(session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '{{ session("error") }}',
            icon: 'error',
            timer: 1500,
            showConfirmButton: false
        });
    </script>
@endif
@stack('js')
</body>


<!-- Mirrored from techzaa.in/lahomes/admin/{{route('home')}} by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Nov 2025 16:44:56 GMT -->
</html>
