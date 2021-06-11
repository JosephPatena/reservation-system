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
@endsection

@section('content')
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Room Details
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-book"></i> Room Details</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-12">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-primary">
              Room
              <h3><small style="color: #fff">No.</small><b>{{ $room->no }}</b><i class="fa fa-edit" style="font-size: 12px; margin-left: 10px;"></i></h3>
              <h5>{{ $room->name }}<i class="fa fa-edit" style="font-size: 12px; margin-left: 10px;"></i></h5>
            </div>

            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a>Reserved <span class="pull-right badge bg-aqua">{{ $room->reservation->where('status_id', 1)->count() }}</span></a></li>
                <li><a>Check In <span class="pull-right badge bg-green">{{ $room->reservation->where('status_id', 2)->count() }}</span></a></li>
                <li><a>Check Out <span class="pull-right badge bg-yellow">{{ $room->reservation->where('status_id', 3)->count() }}</span></a></li>
                <li><a>Cancelled <span class="pull-right badge bg-red">{{ $room->reservation->where('status_id', 4)->count() }}</span></a></li>
                <li><a href="{{ route('room_reports', $room->id) }}"><center>View Reports</center></a></li>
              </ul>
            </div>
          </div><!-- /.widget-user -->
        </div><!-- ./col -->
        <div class="col-lg-9 col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Photos</h3>
              <button class="btn btn-default btn-sm" style="float: right;"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add New Photo</button>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class='row'>
                  @foreach($room->images as $image)
                    <div class='col-sm-4 margin-bottom animate__animated animate__pulse animate__slower'>
                      <i class="fa fa-trash-o" style="position: absolute; font-size:18px; margin:10px; color: red; cursor:pointer;" title="Remove"></i>
                      <img class='img-responsive' src='{{ url('storage/image/' . $image->hash_name) }}' alt='Photo'>
                    </div><!-- /.col -->
                  @endforeach
                </div><!-- /.row -->
              
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
    </div>
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
@endsection