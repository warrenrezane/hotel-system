<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <title>BSHM Hotels | Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="{{ asset('auth_assets/images/icons/favicon.ico') }}" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('auth_assets/vendor/bootstrap/css/bootstrap.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('auth_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('auth_assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('auth_assets/vendor/animate/animate.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('auth_assets/vendor/css-hamburgers/hamburgers.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('auth_assets/vendor/animsition/css/animsition.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('auth_assets/vendor/select2/select2.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('auth_assets/vendor/daterangepicker/daterangepicker.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('auth_assets/css/util.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('auth_assets/css/main.css') }}">
  <!--===============================================================================================-->
</head>

<body style="background-color: #666666;">

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form class="login100-form validate-form" action="{{ route('login') }}" method="POST">
          @csrf

          <span class="login100-form-title p-b-43">
            {{ __('Login')}}
          </span>

          <div class="wrap-input100 validate-input" data-validate="Username is required">
            <input class="input100" type="text" id="username" name="username">
            <span class="focus-input100"></span>
            <span class="label-input100">Username</span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100" type="password" id="password" name="password">
            <span class="focus-input100"></span>
            <span class="label-input100">Password</span>
          </div>

          <div class="flex-sb-m w-full p-t-3 p-b-32">
            <div class="contact100-form-checkbox">
              <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>
              <label class="label-checkbox100" for="ckb1">
                Remember me
              </label>
            </div>
          </div>


          <div class="container-login100-form-btn">
            <button class="login100-form-btn" type="submit">
              {{ __('Login') }}
            </button>
          </div>
        </form>

        <div class="login100-more" style="background-image: url({{ asset('auth_assets/images/bg-01.jpg')}});">
        </div>
      </div>
    </div>
  </div>

  <!--===============================================================================================-->
  <script src="{{ asset('auth_assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('auth_assets/vendor/animsition/js/animsition.min.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('auth_assets/js/sweetalert2.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('auth_assets/vendor/bootstrap/js/popper.js') }}"></script>
  <script src="{{ asset('auth_assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('auth_assets/vendor/select2/select2.min.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('auth_assets/vendor/daterangepicker/moment.min.js') }}"></script>
  <script src="{{ asset('auth_assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('auth_assets/vendor/countdowntime/countdowntime.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('auth_assets/js/main.js') }}"></script>

  @if ($errors->any())
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Account doesn\'t exist in the database!'
    })
  </script>
  @endif
</body>

</html>
