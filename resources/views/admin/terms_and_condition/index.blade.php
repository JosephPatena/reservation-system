@extends('layout.admin')

@section('stylesheets')
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fullcalendar/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/fullcalendar/fullcalendar.print.css" media="print') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Terms and Condition
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-file-word-o"></i> Terms and Condition</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="col-md-8">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Terms and Condition</h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <form action="{{ route('terms_and_condition.update', $termsAndCondition->id) }}" method="post">
              @csrf
              @method('PUT')
              <div class="form-horizontal">
                <div class="form-group">
                  <label for="inputDesc" class="col-sm-2 control-label">Terms and Condition <span style="color: red;">*</span></label>
                  <div class="col-sm-10">
                    <textarea name="text" class="textarea" id="inputDesc" style="width: 100%; height:800px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;" required="">{{ old('text') ? old('text') : $termsAndCondition->text }}</textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputDesc" class="col-sm-2 control-label">&nbsp;</label>
                  <div class="col-sm-10">
                    <button class="btn btn-success btn-sm" type="submit">Save and Refresh</button>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
  </section><!-- /.content -->
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection

@section('scripts')
  <!-- jQuery 2.1.4 -->
  <script src="{{ asset('admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{ asset('admin/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <!-- Slimscroll -->
  <script src="{{ asset('admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('admin/plugins/fastclick/fastclick.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('admin/dist/js/app.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('admin/dist/js/demo.js') }}"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{ asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
  <!-- Page specific script -->
  <script type="text/javascript">
    $(".textarea").wysihtml5();
  </script>
@endsection