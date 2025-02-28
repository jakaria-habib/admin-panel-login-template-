<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Login Page</title>
    <link rel="icon" type="image/x-icon" href="{{asset('admin/assets//favicon.ico')}}" />
    <link href="{{asset('admin/assets/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/css/animate.min.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/css/fontawesome.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/css/toastify.min.css')}}" rel="stylesheet" />
    <script src="{{asset('admin/assets/js/toastify-js.js')}}"></script>
    <script src="{{asset('admin/assets/js/axios.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/config.js')}}"></script>
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
                    <div class="card-body">
                        <h4>SIGN IN</h4>
                        <br/>
                        <input id="email" placeholder="User Email" class="form-control" type="email"/>
                        <br/>
                        <input id="password" placeholder="User Password" class="form-control" type="password"/>
                        <br/>
                        <button onclick="submitLogin()" class="btn w-100" style="background: #006b58; color: #fff;">Next</button>
                        <hr/>
                        <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{url('/registration-page')}}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{url('/send-otp-page')}}">Forget Password</a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{url('/dashboard')}}">Dashboard Page</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>

        async function submitLogin() {
            let email=document.getElementById('email').value;
            let password=document.getElementById('password').value;

            if(email.length === 0){
                errorToast("Email is required");
            }
            else if(password.length ===0 ){
                errorToast("Password is required");
            }
            else{
                showLoader();
                let res = await axios.post("/user-login",{email:email, password:password});
                hideLoader()
                if(res.status === 200 && res.data['status'] === 'success'){
                    window.location.href="/dashboard-page";
                }
                else{
                    errorToast(res.data['message']);
                }
            }
        }

    </script>

</div>
<script>

</script>

<script src="{{asset('admin/assets/js/bootstrap.bundle.js')}}"></script>

</body>
</html>

