<!doctype html>
<html lang="en">
  <head>
    <title>Reservation System | RS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('guest/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('guest/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('guest/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('guest/fonts/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('guest/fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('guest/css/magnific-popup.css') }}">

    <!-- Theme Style -->
    <link rel="stylesheet" href="{{ asset('guest/css/style.css') }}">

    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <style type="text/css">
      body {
          -moz-transform: scale(0.8, 0.8); /* Moz-browsers */
          zoom: 0.8; /* Other non-webkit browsers */
          zoom: 80%; /* Webkit browsers */
      }
    </style>

    @yield('stylesheets')
    @toastr_css
  </head>
  <body>
    
    <header role="banner">
     
      <nav class="navbar navbar-expand-md navbar-dark bg-light">
        <div class="container">
          <a class="navbar-brand" href="/">Reservation System | RS</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
            <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
              
              <li class="nav-item">
                <a class="nav-link {{ Request::is('guest/homepage') ? "active" : "" }}" href="/">Home</a>
              </li>
              
              <li class="nav-item dropdown {{ Request::is('room') ? "active" : "" }}">
                <a class="nav-link dropdown-toggle" href="{{ route('room') }}" id="rooms" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Rooms</a>
                <div class="dropdown-menu" aria-labelledby="rooms">
                  <a class="dropdown-item {{ Request::is('room') ? "active" : "" }}" href="{{ route('room') }}">All</a>
                  @foreach(Helper::get_accomodation() as $accomodation)
                    <a class="dropdown-item {{ Request::is('room/type/'.$accomodation->id) ? "active" : "" }}" href="{{ route('room_type', $accomodation->id) }}">{{ $accomodation->name }}</a>
                  @endforeach
                </div>
              </li>
              
              <li class="nav-item {{ Request::is('about') ? "active" : "" }}">
                <a class="nav-link" href="{{ route('about') }}">About</a>
              </li>
              
              <li class="nav-item {{ Request::is('contact') ? "active" : "" }}">
                <a class="nav-link" href="{{ route('contact') }}">Contact</a>
              </li>

              <li class="nav-item dropdown {{ Request::is('login') || Request::is('register') ? "active" : "" }}">
                <a class="nav-link dropdown-toggle" href="#" id="account" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                <div class="dropdown-menu" aria-labelledby="account">
                  @if(Auth::check())
                    <a class="dropdown-item {{ Request::is('guest/my-profile') ? "active" : "" }}" href="{{ route('my_profile') }}">My Profile</a>
                    <a class="dropdown-item {{ Request::is('reservation') ? "active" : "" }}" href="{{ route('reservation.index') }}">My Reservation</a>
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                  @else
                    <a class="dropdown-item {{ Request::is('login') ? "active" : "" }}" href="{{ route('login') }}">Login</a>
                    <a class="dropdown-item {{ Request::is('register') ? "active" : "" }}" href="{{ route('register') }}">Register</a>
                  @endif
                </div>
              </li>

              <li class="nav-item cta {{ Request::is('reservation/create') ? "active" : "" }}">
                <a class="nav-link" href="{{ route('reservation.create') }}"><span>Book Now</span></a>
              </li>

            </ul>
            
          </div>
        </div>
      </nav>
    </header>
    <!-- END header -->

    @yield('content')
   
    <footer class="site-footer">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-4">
            <h3>Phone Support</h3>
            <p>24/7 Call us now.</p>
            <p class="lead"><a href="tel://">+ 1 332 3093 323</a></p>
          </div>
          <div class="col-md-4">
            <h3>Connect With Us</h3>
            <p>We are socialized. Follow us</p>
            <p>
              <a href="#" class="pl-0 p-3"><span class="fa fa-facebook"></span></a>
              <a href="#" class="p-3"><span class="fa fa-twitter"></span></a>
              <a href="#" class="p-3"><span class="fa fa-instagram"></span></a>
              <a href="#" class="p-3"><span class="fa fa-vimeo"></span></a>
              <a href="#" class="p-3"><span class="fa fa-youtube-play"></span></a>
            </p>
          </div>
          <div class="col-md-4">
            <h3>Connect With Us</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, odio.</p>
            <form action="#" class="subscribe">
              <div class="form-group">
                <button type="submit"><span class="ion-ios-arrow-thin-right"></span></button>
                <input type="email" class="form-control" placeholder="Enter email">
              </div>
              
            </form>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-7 text-center">
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved. Reservation <b>System</b> | R<b>S</b>
          </div>
        </div>
      </div>
    </footer>
    <!-- END footer -->
    
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>

    <script src="{{ asset('guest/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('guest/js/jquery-migrate-3.0.0.js') }}"></script>
    <script src="{{ asset('guest/js/popper.min.js') }}"></script>
    <script src="{{ asset('guest/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('guest/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('guest/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('guest/js/jquery.stellar.min.js') }}"></script>

    <script src="{{ asset('guest/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('guest/js/magnific-popup-options.js') }}"></script>

    <script src="{{ asset('guest/js/main.js') }}"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          cache: false,
      });

      $('#demo').daterangepicker({
          "showISOWeekNumbers": true,
          "timePicker": true,
          "autoUpdateInput": true,
          "locale": {
              "cancelLabel": 'Clear',
              "format": "MMMM DD, YYYY h:mm A",
              "separator": " - ",
              "applyLabel": "Apply",
              "cancelLabel": "Cancel",
              "fromLabel": "From",
              "toLabel": "To",
              "customRangeLabel": "Custom",
              "weekLabel": "W",
              "daysOfWeek": [
                  "Su",
                  "Mo",
                  "Tu",
                  "We",
                  "Th",
                  "Fr",
                  "Sa"
              ],
              "monthNames": [
                  "January",
                  "February",
                  "March",
                  "April",
                  "May",
                  "June",
                  "July",
                  "August",
                  "September",
                  "October",
                  "November",
                  "December"
              ],
              "firstDay": 1
          },
          "linkedCalendars": true,
          "showCustomRangeLabel": false,
          "startDate": 1,
          "opens": "center"
      });

      $(document).on('click', '.open-url', function(){
        let url = $(this).data('url')
        window.open(url, "_self")
      })
    </script>

    @yield('scripts')
    @toastr_js
    @toastr_render
  </body>
</html>