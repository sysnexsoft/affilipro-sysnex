<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ env('APP_NAME', 'Affili Product') }} | Admin Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Secure Admin Login Portal for Affili Product Management Panel." />
    <meta name="author" content="{{ env('APP_NAME', 'Affili Product') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="noindex, nofollow" /> <link rel="shortcut icon" href="{{asset('/')}}Backend/assets/images/favicon.ico">

    <link href="{{asset('/')}}Backend/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <link href="{{asset('/')}}Backend/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <link href="{{asset('/')}}Backend/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <script src="{{asset('/')}}Backend/assets/js/config.min.js"></script>

</head>

<body class="authentication-bg">

<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="card auth-card">
                    <div class="card-body px-3 py-5">
                        <div class="mx-auto mb-4 text-center auth-logo">
                            <a href="" class="logo-dark">
                                <img src="{{asset($web_setting->header_logo)}}" height="32" alt="{{env('APP_NAME')}}">
                            </a>

                            <a href="" class="logo-light">
                                <img src="{{asset($web_setting->header_logo)}}" height="28" alt="{{env('APP_NAME')}}">
                            </a>
                        </div>

                        <h2 class="fw-bold text-uppercase text-center fs-18">Sign In</h2>
                        <p class="text-muted text-center mt-1 mb-4">Enter your email address and password to access admin panel.</p>

                        <div class="px-4">
                            <form action="{{route('login.submit')}}" class="authentication-form" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="example-email">Email <span class="text-danger">*</span></label>
                                    <input type="email" required id="example-email" name="email" class="form-control bg-light bg-opacity-50 border-light py-2" placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="example-password">Password <span class="text-danger">*</span></label>
                                    <input type="password" required id="example-password" name="password" class="form-control bg-light bg-opacity-50 border-light py-2" placeholder="Enter your password">
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" value="1" id="checkbox-signin">
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>

                                <div class="mb-1 text-center d-grid">
                                    <button class="btn btn-danger py-2 fw-medium" type="submit">Sign In</button>
                                </div>
                            </form>
                        </div> </div> </div> </div> </div> </div>
</div>

<script src="{{asset('/')}}Backend/assets/js/jquery.min.js"></script>
<script src="{{asset('/')}}Backend/assets/js/vendor.js"></script>

<script src="{{asset('/')}}Backend/assets/js/app.js"></script>
<script src="{{asset('/')}}Backend/assets/js/sweetalert.js"></script>
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

</body>
</html>
