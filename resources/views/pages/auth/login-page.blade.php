<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Login Page</title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin/assets/favicon.ico')}}" />
    <link href="{{asset('admin/assets/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/css/animate.min.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/css/fontawesome.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/css/toastify.min.css')}}" rel="stylesheet" />
    <script src="{{asset('admin/assets/js/toastify-js.js')}}"></script>
    <script src="{{asset('admin/assets/js/axios.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/config.js')}}"></script>
    <script src="{{asset('admin/assets/js/bootstrap.bundle.js')}}"></script>
</head>

<body>

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
                    <div class="card w-90  p-4">

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <h4>SIGN IN</h4>
                                <br/>
                                <input id="email" name="email" placeholder="User Email" class="form-control" type="email"/>
                                <br/>
                                <input id="password" name="password" placeholder="User Password" class="form-control" type="password"/>
                                <br/>
                                <button type="submit" class="btn w-100" style="background: #006b58; color: #fff;">Next</button>
                                <hr/>
                                <div class="float-end mt-3">
                                <span>
                                    <a class="text-center ms-3 h6" href="#">Sign Up </a>
                                    <span class="ms-1">|</span>
                                    <a class="text-center ms-3 h6" href="#">Forget Password</a>
                                </span>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

