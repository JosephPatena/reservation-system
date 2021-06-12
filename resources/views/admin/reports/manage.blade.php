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
      Reports
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-newspaper-o"></i> Reports</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-black" style="background: url('{{ asset('admin/dist/img/photo1.png') }}') center center;">
            <h3 class="widget-user-username">{{ $reservation->guest->name }}</h3>
            <h5 class="widget-user-desc">Guest</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src="{{ !empty($reservation->guest->image->hash_name) ? url('storage/image/'.$reservation->guest->image->hash_name) : asset('admin/dist/img/default-user.png') }}" alt="User Avatar">
          </div>
          <div class="box-footer no-padding">
            <ul class="nav nav-stacked">
              <li><a>Reserved <span class="pull-right badge bg-aqua">{{ $reservation->guest->reservation->where('status_id', 1)->count() }}</span></a></li>
              <li><a>Check In <span class="pull-right badge bg-green">{{ $reservation->guest->reservation->where('status_id', 2)->count() }}</span></a></li>
              <li><a>Check Out <span class="pull-right badge bg-yellow">{{ $reservation->guest->reservation->where('status_id', 3)->count() }}</span></a></li>
              <li><a>Cancelled <span class="pull-right badge bg-red">{{ $reservation->guest->reservation->where('status_id', 4)->count() }}</span></a></li>
              <li><a href="{{ route('guest', $reservation->guest->id) }}"><center>View Reports</center></a></li>
            </ul>
          </div>
        </div><!-- /.widget-user -->

        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user-2">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-default">
          
            <h3><small>Room <br> No.</small> <b>{{ $reservation->room->no }}</b></h3>
            <i class="fa fa-folder-open-o open-url" data-url="{{ route('rooms.show', $reservation->room->id) }}" style="float: right; cursor: pointer;" title="View / Edit details"></i>
            <h5>{{ $reservation->room->name }}</h5>
          </div>
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              @foreach($reservation->room->images as $index => $image)
                <li data-target="#carousel-example-generic-{{ $index }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? "active" : "" }}"></li>
              @endforeach
            </ol>
            <div class="carousel-inner">
              @foreach($reservation->room->images as $index => $image)
              <div class="item {{ $index == 0 ? "active" : "" }}">
                <img src="{{ url('storage/image/' . $image->hash_name) }}" alt="{{ $reservation->room->accomodation->name }}">
                <div class="carousel-caption">
                  {{ $reservation->room->accomodation->name }}
                </div>
              </div>
              @endforeach
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
              <span class="fa fa-angle-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
              <span class="fa fa-angle-right"></span>
            </a>
          </div>
          <div class="box-footer no-padding">
            <ul class="nav nav-stacked">
              <li><a>Reserved <span class="pull-right badge bg-aqua">{{ $reservation->room->reservation->where('status_id', 1)->count() }}</span></a></li>
              <li><a>Check In <span class="pull-right badge bg-green">{{ $reservation->room->reservation->where('status_id', 2)->count() }}</span></a></li>
              <li><a>Check Out <span class="pull-right badge bg-yellow">{{ $reservation->room->reservation->where('status_id', 3)->count() }}</span></a></li>
              <li><a>Cancelled <span class="pull-right badge bg-red">{{ $reservation->room->reservation->where('status_id', 4)->count() }}</span></a></li>
              <li><a href="{{ route('room_reports', $reservation->room->id) }}"><center>View Reports</center></a></li>
            </ul>
          </div>
        </div><!-- /.widget-user -->
			</div>
		  <div class="col-lg-9 col-md-8">

		      <div class="box">
		        <div class="box-header">
		          <h3 class="box-title">Reservation Details</h3>
		        </div><!-- /.box-header -->
		        <div class="box-body">
		          <table id="example1" class="table table-bordered table-striped">
		            <thead>
		              <tr>
		                <th>Room Type</th>
		                <th>Price</th>
		                <th>Arrival Date</th>
		                <th>Departure Date</th>
		                <th>Length of Stay (day)</th>
		                <th>Total</th>
                    <th>Status</th>
		              </tr>
		            </thead>
		            <tbody>
		            		<tr>
		            			<td>{{ $reservation->room->accomodation->name }}</td>
		            			<td>{{ Helper::get_owner_currency()->currency->symbol . number_format($reservation->room->price, 2) }}</td>
		            			<td>{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("F d, Y h:i A") }}</td>
		            			<td>{{ \Carbon\Carbon::parse($reservation->departure_date)->format("F d, Y h:i A") }}</td>
		            			<td>{{ $reservation->length_of_stay }}</td>
		            			<td>{{ Helper::get_owner_currency()->currency->symbol . number_format($reservation->total, 2) }}</td>
                      <td>
                        @if($reservation->status_id == 1)
                          <span class="badge bg-aqua">{{ $reservation->status->name }}</span>
                        @elseif($reservation->status_id == 2)
                          <span class="badge bg-red">{{ $reservation->status->name }}</span>
                        @elseif($reservation->status_id == 3)
                          <span class="badge bg-green">{{ $reservation->status->name }}</span>
                        @else
                          <span class="badge bg-yellow">{{ $reservation->status->name }}</span>
                        @endif
                      </td>
		            		</tr>
		            </tbody>
		          </table>
		        </div><!-- /.box-body -->
		      </div><!-- /.box -->
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
  <script>
    $(function () {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });
  </script>
@endsection