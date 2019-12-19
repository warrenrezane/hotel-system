<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  {{-- Necessary CSS --}}
  <link rel="stylesheet" href="{{ asset('material-icons/iconfont/material-icons.css') }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="{{ asset('dashboard_assets/css/material-dashboard.css?v=2.1.1') }}" rel="stylesheet" />
  {{-- Necessary JS --}}
  <script src="{{ asset('dashboard_assets/js/core/jquery.min.js') }}"></script>
  <script src="{{ asset('dashboard_assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('auth_assets/js/sweetalert2.js') }}"></script>
  <script src="{{ asset('dashboard_assets/js/core/bootstrap-material-design.min.js') }}"></script>
  <script src="{{ asset('dashboard_assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
  <script src="{{ asset('dashboard_assets/js/material-dashboard.js') }}" type="text/javascript"></script>
  {{-- DHTMLX Scheduler --}}
  @stack('scheduler')
  {{-- Custom --}}
  @stack('custom')
  <style>
    .swal-size {
      width: 350px !important;
    }

    .month-swal-size {
      width: 250px !important;
    }
  </style>
  <title>BSHM Hotels | @stack('name') </title>
</head>

<body>
  <div class="wrapper">
    <div class="sidebar" data-color="purple" data-background-color="white"
      data-image="{{ asset('dashboard_assets/img/sidebar-1.jpg') }}">
      <div class="logo">
        <a href="#" class="simple-text logo-normal">
          BSHM Hotel
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item {{ request()->routeIs('home') ? 'active' : (request()->is('/') ? 'active' : '') }}">
            <a class="nav-link" href="/home">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('bookings') ? 'active' : '' }}">
            <a class="nav-link" href="/bookings">
              <i class="material-icons">content_paste</i>
              <p>Bookings</p>
            </a>
          </li>
          @if (Auth::user()->access_level === 2)
          <li class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <a class="nav-link" href="/admin/users">
              <i class="material-icons">assignment_ind</i>
              <p>User Management</p>
            </a>
          </li>
          @endif
          <li class="nav-item {{ request()->is('report*') ? 'active' : '' }}">
            <a class="nav-link" id="report" href="#">
              <i class="material-icons">list_alt</i>
              <p>Report</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="material-icons">person</i>
              <p>Log-out</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      @yield('nav')
      <!-- End Navbar -->
      <div class="content">
        @yield('content')
      </div>
    </div>
  </div>

  <script>
    // function getMonthly(month, year) {
    //   window.location.href = `/report/${month}/${year}`;
    // }

    // function getAnnually(year) {
    //   window.location.href = `/report/${year}`;
    // }

    // function displayMonths() {
    //   Swal.fire({
    //     title: 'Pick a month',
    //     html:
    //       `<div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(1, 2019)">January</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(2, 2019)">February</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(3, 2019)">March</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(4, 2019)">April</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(5, 2019)">May</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(6, 2019)">June</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(7, 2019)">July</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(8, 2019)">August</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(9, 2019)">September</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(10, 2019)">October</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(11, 2019)">November</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-success" style="width: 150px;" onclick="getMonthly(12, 2019)">December</button>
    //       </div>`,
    //     customClass: 'month-swal-size',
    //     showCloseButton: true,
    //     showConfirmButton: false,
    //   })
    // }

    // function displayYears() {
    //   Swal.fire({
    //     title: 'Pick a year',
    //     html:
    //       `<div>
    //         <button class="btn btn-warning" onclick="getAnnually(2019);">2019</button>
    //       </div>
    //       <div>
    //         <button class="btn btn-warning" onclick="getAnnually(2020);">2020</button>
    //       </div>`,
    //     customClass: 'month-swal-size',
    //     showCloseButton: true,
    //     showConfirmButton: false,
    //   })
    // }

    function check() {
      var fromDate = document.getElementById('fromDate');
      var toDate = document.getElementById('toDate');
      if (!fromDate.checkValidity()) {
        alert('From date is required!')
      }
      else if (!toDate.checkValidity()) {
        alert('To date is required!')
      }
      else {
        window.location.href = `/report/${fromDate.value}/${toDate.value}`;
        console.log(`From: ${fromDate.value} To: ${toDate.value}`);
      }
    }

    $('#report').on('click', function () {
      Swal.fire({
        html:
          `<div>
            <label style="font-size: 20px;">From:</label>
            <input type="date" id="fromDate" class="form-control" required/>
          </div>
          <div class="mt-4">
            <label style="font-size: 20px;">To:</label>
            <input type="date" id="toDate" class="form-control" required/>
          </div>
          <div>
            <button class="btn btn-primary mt-4" onclick="check()">Submit</button>
          </div>`,
        showConfirmButton: false,
        customClass: 'swal-size',
      })
    })
  </script>
</body>

</html>
