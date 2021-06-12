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
      Reservation Reports
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-newspaper-o"></i>Reservation Reports</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
		<div class="row">
		  <div class="col-xs-12">

		      <div class="box">
		        <div class="box-header">
		          <h3 class="box-title">Booking History</h3>
		        </div><!-- /.box-header -->
		        <div class="box-body">
		          <table id="example1" class="table table-bordered table-striped">
		            <thead>
		              <tr>
		              	<th>#</th>
		              	<th>Room</th>
		                <th>Room Type</th>
		                <th>Price</th>
		                <th>Arrival Date</th>
		                <th>Departure Date</th>
		                <th>Length of Stay (day)</th>
		                <th>Guest</th>
		                <th>Status</th>
		                <th>Total</th>
		                <th style="width: 10px !important">Action</th>
		              </tr>
		            </thead>
		            <tbody>
		            	@foreach($reservations as $key => $reservation)
		            		<tr>
		            			<td>{{ $key+1 }}.</td>
		            			<td>
	                      <img class="open-url" data-url="{{ route('room_reports', $reservation->room->id) }}" data-toggle="tooltip" title="View Reports" style="width: 25px; height: 25px; cursor: pointer;" src="{{ url('storage/image/' . $reservation->room->images->first()->hash_name) }}" alt="Room Image">&nbsp;&nbsp;<a href="{{ route('room_reports', $reservation->room->id) }}"  data-toggle="tooltip" title="View Reports">{{ $reservation->room->name }}</a>
		            			</td>
		            			<td>{{ $reservation->room->accomodation->name }}</td>
		            			<td>{{ Helper::get_owner_currency()->currency->symbol . number_format($reservation->room->price, 2) }}</td>
		            			<td>{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("F d, Y h:i A") }}</td>
		            			<td>{{ \Carbon\Carbon::parse($reservation->departure_date)->format("F d, Y h:i A") }}</td>
		            			<td>{{ $reservation->length_of_stay }}</td>
		            			<td>
		                    <img class="open-url" data-url="{{ route('guest', $reservation->guest->id) }}" data-toggle="tooltip" title="View Reports" style="width: 25px; height: 25px; cursor: pointer;" src="{{ !empty($reservation->guest->image->hash_name) ? url('storage/image/'.$reservation->guest->image->hash_name) : asset('admin/dist/img/default-user.png') }}" alt="Guest Image">&nbsp;&nbsp;<a href="{{ route('guest', $reservation->guest->id) }}"  data-toggle="tooltip" title="View Reports">{{ $reservation->guest->name }}</a>
		            			</td>
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
		            			<td><button class="btn btn-primary btn-sm open-url" data-url="{{ route('reports.show', $reservation->id) }}" data-toggle="tooltip" title="Show Details"><i class="fa fa-folder-open-o"></i></button></td>
		            		</tr>
		            	@endforeach
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