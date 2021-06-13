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
@endsection

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Overview
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> Overview</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10">
          
        @foreach($rooms as $room)
        <div class="col-md-2">
          <div class="small-box bg-aqua">
            <div class="inner">
              Room No.<h3>{{ $room->no }}</h3>
            <i class="fa fa-folder-open-o open-url" data-url="{{ route('rooms.show', $room->id) }}" style="float: right; cursor: pointer;" data-toggle="tooltip" title="View / Edit details"></i>
              <p>{{ $room->accomodation->name }}</p>
            </div>
            <a href="{{ route('room_reports', $room->id) }}" class="small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endforeach
      </div>
      <div class="col-md-2">
        <!-- small box -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Legend</h3>
          </div><!-- /.box-header -->
          <div class="box-body row" style="text-align: center;">
              <span class="label bg-aqua">Reserved</span>
              <span class="label bg-green">Check In</span>
              <span class="label bg-yellow">Check Out</span>
              <span class="label bg-red">Cancelled</span>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        
      </div>
      
    </div><!-- /.row -->
  </section><!-- /.content -->
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
  <!-- fullCalendar 2.2.5 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{ asset('admin/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
  <!-- Page specific script -->
@endsection