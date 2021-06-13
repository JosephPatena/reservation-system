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

      <div class="col-md-2 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3>{{ Helper::get_room()->count() }}</h3>
            <p>Total Room</p>
          </div>
          <div class="icon">
            <i class="fa fa-star"></i>
          </div>
          <a href="{{ route('rooms.index') }}" class="small-box-footer">View Rooms <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-2 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ Helper::get_reservation()->where('status_id', 1)->count() }}</h3>
            <p>Total Reserved</p>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-plus-o"></i>
          </div>
          <a href="#" data-filter="Reserved" class="filter small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-2 col-xs-6">  
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ Helper::get_reservation()->where('status_id', 3)->count() }}<sup style="font-size: 20px"></sup></h3>
            <p>Total Check In</p>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-check-o"></i>
          </div>
          <a href="#" data-filter="Check In" class="filter small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-2 col-xs-6">  
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ Helper::get_reservation()->where('status_id', 4)->count() }}</h3>
            <p>Total Check Out</p>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-times-o"></i>
          </div>
          <a href="#" data-filter="Check Out" class="filter small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-2 col-xs-6">  
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{ Helper::get_reservation()->where('status_id', 2)->count() }}</h3>
            <p>Total Cancelled</p>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-minus-o"></i>
          </div>
          <a href="#" data-filter="Cancelled" class="filter small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-2 col-xs-6">  
        <!-- small box -->
        <div class="small-box bg-maroon">
          <div class="inner">
            <h3>{{ Helper::get_guest()->count() }}</h3>
            <p>Total Guest</p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="{{ route('guests') }}" class="small-box-footer">View Guests <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-12">
        <div class="col-md-4">
          <!-- Date range -->
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">
                Filter Date:
              </div>
              <input type="text" class="form-control pull-right" id="date_range">
            </div><!-- /.input group -->
          </div><!-- /.form group -->
        </div>
        <div class="col-md-8">
          <div class="btn-group pull-right">
            <button type="button" class="btn btn-sm btn-success" style="pointer-events: none;">Export as</button>
            <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="{{ route('reports_to_pdf') }}">PDF</a></li>
              <li><a href="{{ route('reports_to_export') }}">Excel</a></li>
            </ul>
          </div>
        </div>
      </div>

		  <div class="col-md-12">

		      <div class="box">
		        <div class="box-header">
		          <h3 class="box-title">Booking History</h3>
              <span class="pull-right">
                <label>Showing: </label> {{ Session::has('date_range') ? Session::get('date_range') : "All" }}
              </span>
		        </div><!-- /.box-header -->
		        <div class="box-body table-responsive">
		          <table id="example1" class="table table-bordered table-striped">
		            <thead>
		              <tr>
		              	<th>#</th>
		              	<th>Invoice</th>
		              	<th>Room</th>
		                <th>Room Type</th>
		                <th>Price</th>
		                <th>Arrival Date</th>
		                <th>Departure Date</th>
		                <th>Length of Stay (day)</th>
		                <th>Guest</th>
		                <th>Total</th>
		                <th>Status</th>
                    <th>Payment Method</th>
		                <th style="width: 10px !important">Action</th>
		              </tr>
		            </thead>
		            <tbody>
		            	@foreach($reservations as $key => $reservation)
		            		<tr>
		            			<td>{{ $key+1 }}.</td>
		            			<td>{{ $reservation->invoice_no }}</td>
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
                      <td>{{ $reservation->payment_method->name }}</td>
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
  <!-- Include Date Range Picker -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
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

      //Date range picker with time picker
      $('#date_range').daterangepicker({
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
    });

    $('#date_range').on('apply.daterangepicker', function(){
      $.ajax({
        url: '{{ route('set_date_range') }}',
        data: {date_range: $(this).val()},
        dataType: 'json',
        type: 'post'
      })
      .done(function(){
        window.location.reload(true)
      })
      .fail(function(){
        toastr.error("Failed! Something went wrong")
      })
    })

    var table = $('#example1').DataTable();
 
    // #myInput is a <input type="text"> element
    $('.filter').on('click', function(){
        table.search( $(this).data('filter') ).draw();
    });
  </script>
@endsection