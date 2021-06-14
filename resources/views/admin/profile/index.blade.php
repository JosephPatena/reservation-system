@extends('layout.admin')

@section('stylesheets')
  <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">

    <style type="text/css">
        .toggle {
            --width: 40px;
            --height: calc(var(--width) / 2);
            --border-radius: calc(var(--height) / 2);

            display: inline-block;
            cursor: pointer;
        }
        .toggle__input {
            display: none;
        }
        .toggle__fill {
            position: relative;
            width: var(--width);
            height: var(--height);
            border-radius: var(--border-radius);
            background: #dddddd;
            transition: background 0.2s;
        }
        .toggle__fill::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: var(--height);
            width: var(--height);
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
            border-radius: var(--border-radius);
            transition: transform 0.2s;
        }
        .toggle__input:checked ~ .toggle__fill {
            background: #009578;
        }

        .toggle__input:checked ~ .toggle__fill::after {
            transform: translateX(var(--height));
        }
    </style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profile
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-4"></div>
        <div class="col-md-4">
          <form action="{{ route('update_profile') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Widget: user widget style 1 -->
            <input type="hidden" name="id" value="{{ encrypt(Auth::id()) }}">
            <div class="box box-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-yellow">
                <div class="widget-user-image">
                  <img class="img-circle change" src="{{ !empty(Helper::get_user()->image->hash_name) ? url('storage/image/'.Helper::get_user()->image->hash_name) : asset('admin/dist/img/default-user.png') }}" alt="User Avatar" style="cursor: pointer;" data-toggle="tooltip" title="Click to Change Photo">
                  <input class="file" type="file" name="image" style="display: none;">
                </div><!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
                <h5 class="widget-user-desc">Administrator</h5>
              </div>
              <div class="box">
                <div class="box-body">
                  
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputName" placeholder="Email" name="name" required="" value="{{ Auth::user()->name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputUsername" class="col-sm-4 col-form-label">Username</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="email" required="" value="{{ Auth::user()->email }}">
                    </div>
                  </div>
                  <br>
                  <div class="form-group row">
                    <label class="col-sm-4 control-label">Change Password</label>
                    <div class="col-sm-4">
                        <label class="toggle">
                            <input class="toggle__input" name="change_pass" data-id="1" type="checkbox" {{ old('change_pass') ? "checked" : "" }}>
                            <div class="toggle__fill"></div>
                        </label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-4 col-form-label">Password</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password" value="{{ old('password') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputRetypePassword" class="col-sm-4 col-form-label">Retype Password</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="inputRetypePassword" placeholder="Retype Password" name="confirm_password" value="{{ old('confirm_password') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-4 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">
                      <button class="btn btn-success btn-sm">Update and Refresh</button>
                    </div>
                  </div>

                </div>
              </div>
            </div><!-- /.widget-user -->
          </form>
        </div><!-- /.col -->
    </div><!-- /.row -->
  </section>

@endsection

@section('scripts')
  <!-- jQuery 2.1.4 -->
  <script src="{{ asset('admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{ asset('admin/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <!-- SlimScroll -->
  <script src="{{ asset('admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('admin/plugins/fastclick/fastclick.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin/dist/js/app.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
  <!-- page script -->
  <script type="text/javascript">
    $('img.change').on('click', function(){
      $('input.file').click()
    })

    $('input.file').on('change', function(){
      if (event.target.files[0]) {
              $('img.change').attr("src", URL.createObjectURL(event.target.files[0]));
              return true;
      }
      $('img.change').attr("src", "{{ !empty(Helper::get_user()->image->hash_name) ? url('storage/image/'.Helper::get_user()->image->hash_name) : asset('admin/dist/img/default-user.png') }}");
    })
  </script>
@endsection