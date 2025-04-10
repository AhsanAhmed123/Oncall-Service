<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Loader -->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    
    <!-- Plugins -->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/jquery-3.7.1.js') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/dark-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/semi-dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/header-colors.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" integrity="sha512-v8QQ0YQ3H4K6Ic3PJkym91KoeNT5S3PnDKvqnwqFD1oiqIl653crGZplPdU5KKtHjO0QKcQ2aUlQZYjHczkmGw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css" integrity="sha512-58P9Hy7II0YeXLv+iFiLCv1rtLW47xmiRpC1oFafeKNShp8V5bKV/ciVtYqbk2YfxXQMt58DjNfkXFOn62xE+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

  <style>
    /* Add hover effects to links */
    a {
      transition: color 0.3s ease, background-color 0.3s ease;
    }

    a:hover {
      color: #007bff !important;
      text-decoration: none;
    }

    /* Sidebar menu hover effects */
    .metismenu a:hover {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 5px;
    }

    /* Dropdown menu hover effects */
    .dropdown-menu a:hover {
      background-color: #f8f9fa;
      color: #007bff !important;
    }

    /* Search bar focus effect */
    .searchbar input:focus {
      border-color: #007bff;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Dark mode icon hover effect */
    .dark-mode-icon:hover .mode-icon {
      transform: scale(1.1);
    }

    /* User dropdown hover effect */
    .dropdown-user-setting:hover .user-setting {
      transform: scale(1.05);
    }

    /* Smooth transitions for icons */
    ion-icon {
      transition: transform 0.3s ease;
    }

    ion-icon:hover {
      transform: scale(1.2);
    }
  </style>

  <title>Admin Panel</title>
</head>

<body>
  <!-- Start wrapper -->
  <div class="wrapper">
    <!-- Start sidebar -->
    <aside class="sidebar-wrapper" data-simplebar="true">
      <div class="sidebar-header">
        <div style="width: 130px;margin: 51px;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100px">
        </div>
       
      </div>
      <!-- Navigation -->
      <ul class="metismenu" id="menu">
        <li>
          <a href="{{route('index-dashboard')}}">
            <div class="parent-icon">
              <ion-icon name="home-outline"></ion-icon>
            </div>
            <div class="menu-title">Dashboard</div>
          </a>
        </li>
        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="bag-handle-outline"></ion-icon>
            </div>
            <div class="menu-title">Information</div>
          </a>
          <ul>
            <li><a href="{{route('index-departmemts')}}">
                <ion-icon name="ellipse-outline"></ion-icon>Department
              </a>
            </li>
            <li><a href="{{route('index-ivr')}}">
                <ion-icon name="ellipse-outline"></ion-icon>IVR
              </a>
            </li>
            <li><a href="{{route('index-sms')}}">
                <ion-icon name="ellipse-outline"></ion-icon>Send Message
              </a>
            </li>
            @if(Auth::user()->business_details && Auth::user()->business_details->survey == 1)
            <li><a href="{{route('index-survey')}}">
                <ion-icon name="ellipse-outline"></ion-icon>Survey
              </a>
            </li>
            @endif
            <li>
            <a href="{{ route('roster.index') }}">
              <ion-icon name="ellipse-outline"></ion-icon> Manage Roster
            </a>
          </li>
            <li><a href="{{route('oncall.index')}}">
                <ion-icon name="ellipse-outline"></ion-icon>Oncall People
              </a>
            </li>
            <li><a href="{{route('backup')}}">
                <ion-icon name="ellipse-outline"></ion-icon>Backup
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="briefcase-outline"></ion-icon>
            </div>
            <div class="menu-title">Reports</div>
          </a>
         <ul>
            <li> <a href="/call-report">
                <ion-icon name="#"></ion-icon>Call Reports
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
              <i class="fadeIn animated bx bx-align-justify"></i>
            </div>
            <div class="menu-title">Settings</div>
          </a>
          <ul>
            <li> <a href="/email-create">
                <ion-icon name="ellipse-outline"></ion-icon>Email
              </a>
            </li>
            <li> <a href="/sms-create">
                <ion-icon name="ellipse-outline"></ion-icon>SMS
              </a>
            </li>
      </ul>
      <!-- End navigation -->
    </aside>
    <!-- End sidebar -->

    <!-- Start top header -->
    <header class="top-header">
      <nav class="navbar navbar-expand gap-3">
        <div class="toggle-icon">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
        <form class="searchbar">
          <div class="position-absolute top-50 translate-middle-y search-icon ms-3">
            <ion-icon name="search-outline"></ion-icon>
          </div>
          <input class="form-control" type="text" placeholder="Search for anything">
          <div class="position-absolute top-50 translate-middle-y search-close-icon">
            <ion-icon name="close-outline"></ion-icon>
          </div>
        </form>
        <div class="top-navbar-right ms-auto">
          <ul class="navbar-nav align-items-center">
         
           
            <li class="nav-item dropdown dropdown-user-setting">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                <div class="user-setting">
                {{Auth::user()->name}}
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="javascript:;">
                    <div class="d-flex flex-row align-items-center gap-2">
                      <!--<img src="assets/images/avatars/06.png" alt="" class="rounded-circle" width="54" height="54">-->
                      <div class="">
                        <h6 class="mb-0 dropdown-user-name">{{Auth::user()->name}}</h6>
                        
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="{{route('profile')}}">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <ion-icon name="person-outline"></ion-icon>
                      </div>
                      <div class="ms-3"><span>Profile</span></div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{route('change-password')}}">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <ion-icon name="person-outline"></ion-icon>
                      </div>
                      <div class="ms-3"><span>Change Password</span></div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{route('logout')}}">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <ion-icon name="log-out-outline"></ion-icon>
                      </div>
                      <div class="ms-3"><span>Logout</span></div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- End top header -->

    <!-- Main content -->
    <main>
      @yield('content')
    </main>
  </div>
  <!-- End wrapper -->

  
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/easyPieChart/jquery.easypiechart.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    
    <!-- External Bootstrap Link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  @yield('scripts')
 
  <script>
    
        @if (session('success'))
            toastr.success('{{ session('success') }}', 'Success');
        @endif

        @if (session('error'))
            toastr.error('{{ session('error') }}', 'Errors');
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        toastr.options = {
            "closeButton": true, // Show close button
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          };
  </script>
</body>
</html>
