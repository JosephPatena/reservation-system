<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reservation System | RS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!--====== Animate ======-->
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    @yield('stylesheets')

    <style type="text/css">
      body {
          -moz-transform: scale(0.8, 0.8); /* Moz-browsers */
          zoom: 0.8; /* Other non-webkit browsers */
          zoom: 80%; /* Webkit browsers */
      }
    </style>

    @toastr_css
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">R<b>S</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Reservation <b>System</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-comment-o"></i>
                  @if(Helper::get_inquiries()->where('seen', false)->count() > 0)
                    <span class="label label-success">{{ Helper::get_inquiries()->where('seen', false)->count() }}</span>
                  @endif
                </a>
                @if(Helper::get_inquiries()->where('seen', false)->count() > 0)
                  <ul class="dropdown-menu">
                    <li class="header">You have {{ Helper::get_inquiries()->where('seen', false)->count() }} inquiries</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <ul class="menu">
                        @foreach(Helper::get_inquiries()->where('seen', false) as $inquiry)
                          <li><!-- start message -->
                            <a href="#">
                              <div class="pull-left">
                                <img src="{{ (!empty($inquiry->guest->image->hash_name) && $inquiry->same_as_profile) ? url('storage/image/'.$inquiry->guest->image->hash_name) : asset('admin/dist/img/default-user.png') }}" class="img-circle" alt="User Image">
                              </div>
                              <h4>
                                {{ $inquiry->name }}
                                <small><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($inquiry->created_at)->diffForHumans() }}</small>
                              </h4>
                              <p>{{ $inquiry->message }}</p>
                            </a>
                          </li><!-- end message -->
                        @endforeach

                        @foreach(Helper::get_inquiries()->where('seen', true)->take(10) as $inquiry)
                          <li><!-- start message -->
                            <a href="#">
                              <div class="pull-left">
                                <img src="{{ (!empty($inquiry->guest->image->hash_name) && $inquiry->same_as_profile) ? url('storage/image/'.$inquiry->guest->image->hash_name) : asset('admin/dist/img/default-user.png') }}" class="img-circle" alt="User Image">
                              </div>
                              <h4>
                                {{ $inquiry->name }}
                                <small><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($inquiry->created_at)->diffForHumans() }}</small>
                              </h4>
                              <p>{{ $inquiry->message }}</p>
                            </a>
                          </li><!-- end message -->
                        @endforeach
                      </ul>
                    </li>
                    <li class="footer"><a href="{{ route('inquiries.index') }}">See All Inquiries</a></li>
                  </ul>
                @endif
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bookmark-o"></i>
                  @if(Helper::get_reservation()->where('seen', false)->count() > 0)
                    <span class="label label-success">{{ Helper::get_reservation()->where('seen', false)->count() }}</span>
                  @endif
                </a>
                @if(Helper::get_reservation()->where('seen', false)->count() > 0)
                  <ul class="dropdown-menu">
                    <li class="header">You have {{ Helper::get_reservation()->where('seen', false)->count() }} new reservation(s)</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <ul class="menu">
                        @foreach(Helper::get_reservation()->where('seen', false) as $rsvtn)
                          <li>
                            <a href="{{ route('reports.show', $rsvtn->id) }}" class="text-green">
                              <i class="fa fa-bookmark-o"></i>
                              @if($rsvtn->status_id == 1)
                                <span class="badge bg-aqua">{{ $rsvtn->status->name }}</span>
                              @elseif($rsvtn->status_id == 2)
                                <span class="badge bg-red">{{ $rsvtn->status->name }}</span>
                              @elseif($rsvtn->status_id == 3)
                                <span class="badge bg-green">{{ $rsvtn->status->name }}</span>
                              @else
                                <span class="badge bg-yellow">{{ $rsvtn->status->name }}</span>
                              @endif
                              &nbsp;
                              {{ $rsvtn->room->accomodation->name }}
                              &nbsp;
                              Invoice #{{ $rsvtn->invoice_no }}
                            </a>
                          </li>
                        @endforeach

                        @foreach(Helper::get_reservation()->where('seen', true)->take(10) as $rsvtn)
                          <li>
                            <a href="{{ route('reports.show', $rsvtn->id) }}">
                              <i class="fa fa-bookmark-o"></i>
                              @if($rsvtn->status_id == 1)
                                <span class="badge bg-aqua">{{ $rsvtn->status->name }}</span>
                              @elseif($rsvtn->status_id == 2)
                                <span class="badge bg-red">{{ $rsvtn->status->name }}</span>
                              @elseif($rsvtn->status_id == 3)
                                <span class="badge bg-green">{{ $rsvtn->status->name }}</span>
                              @else
                                <span class="badge bg-yellow">{{ $rsvtn->status->name }}</span>
                              @endif
                              &nbsp;
                              {{ $rsvtn->room->accomodation->name }}
                              &nbsp;
                              Invoice #{{ $rsvtn->invoice_no }}
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    </li>
                    <li class="footer"><a href="{{ route('manage_reservation') }}">View all</a></li>
                  </ul>
                @endif
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{ !empty(Helper::get_user()->image->hash_name) ? url('storage/image/'.Helper::get_user()->image->hash_name) : asset('admin/dist/img/default-user.png') }}" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{ !empty(Helper::get_user()->image->hash_name) ? url('storage/image/'.Helper::get_user()->image->hash_name) : asset('admin/dist/img/default-user.png') }}" class="img-circle" alt="User Image">
                    <p>
                      Reservation System
                      <small>Administrator</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{ !empty(Helper::get_user()->image->hash_name) ? url('storage/image/'.Helper::get_user()->image->hash_name) : asset('admin/dist/img/default-user.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{ Auth::user()->name }}</p>
              <a class="indicator"><i class="fa fa-circle" style="color:lime"></i>&nbsp;&nbsp;&nbsp;Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ Request::is('admin/homepage') ? "active" : "" }}">
              <a href="/">
                <i class="fa fa-home"></i> <span>Overview</span>
              </a>
            </li>
            <li class="{{ Request::is('calendar') ? "active" : "" }}">
              <a href="{{ route('calendar.index') }}">
                <i class="fa fa-calendar"></i> <span>Calendar</span>
              </a>
            </li>
            <li class="{{ Request::is('rooms') ? "active" : "" }}">
              <a href="{{ route('rooms.index') }}">
                <i class="fa fa-star"></i> <span>Rooms</span>
              </a>
            </li>
            <li class="{{ Request::is('accomodation') ? "active" : "" }}">
              <a href="{{ route('accomodation.index') }}">
                <i class="fa fa-book"></i> <span>Accomodation</span>
              </a>
            </li>
            <li class="{{ Request::is('manage/reservation') ? "active" : "" }}">
              <a href="{{ route('manage_reservation') }}">
                <i class="fa fa-bookmark"></i> <span>Reservation</span>
                @if(Helper::get_reservation()->where('seen', false)->count() > 0)
                  <small class="label pull-right bg-green">{{ Helper::get_reservation()->where('seen', false)->count() }} New</small>
                @endif
              </a>
            </li>
            <li class="{{ Request::is('reports') ? "active" : "" }}">
              <a href="{{ route('reports.index') }}">
                <i class="fa fa-newspaper-o"></i> <span>Reports</span>
              </a>
            </li>
            <li class="{{ Request::is('guests') ? "active" : "" }}">
              <a href="{{ route('guests') }}">
                <i class="fa fa-users"></i> <span>Guest</span>
              </a>
            </li>
            <li class="{{ Request::is('billing') ? "active" : "" }}">
              <a href="{{ route('billing.index') }}">
                <i class="fa fa-credit-card"></i> <span>Billing</span>
              </a>
            </li>
            <li class="{{ Request::is('inquiries') ? "active" : "" }}">
              <a href="{{ route('inquiries.index') }}">
                <i class="fa fa-comment-o"></i> <span>inquiries</span>
                @if(Helper::get_inquiries()->where('seen', false)->count() > 0)
                  <small class="label pull-right bg-green">{{ Helper::get_inquiries()->where('seen', false)->count() }} New</small>
                @endif
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        @yield('content')
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2021 <a href="/">Reservation System</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <div class="tab-content">
          <div class="tab-pane" id="control-sidebar-home-tab">
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    @yield('scripts')

    <script type="text/javascript">
      $(document).on('click', '.open-url', function(){
        let url = $(this).data('url')
        window.open(url, "_self")
      })

      function checkIfOnline(){
        if(navigator.onLine){
          $('.indicator').html('<i class="fa fa-circle" style="color:lime"></i>&nbsp;&nbsp;&nbsp;Online')
        } else {
          $('.indicator').html('<i class="fa fa-circle" style="color:gray"></i>&nbsp;&nbsp;&nbsp;Offline')
        } 
      }
      setInterval(checkIfOnline, 1000);


      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          cache: false,
      });
    </script>

    @toastr_js
    @toastr_render
  </body>
</html>
