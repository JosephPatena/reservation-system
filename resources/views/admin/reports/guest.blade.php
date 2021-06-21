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
      Guest Reservation
      <small>Reports</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-newspaper-o"></i> Guest Reservation</a></li>
      <li class="active">Reports</li>
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
            <h3 class="widget-user-username">{{ $guest->name }}</h3>
            <h5 class="widget-user-desc">
              @if($guest->restricted)
                <span class="badge bg-red">Restricted</span>
              @else
                <span class="badge bg-green">Unrestricted</span>
              @endif
            </h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src="{{ !empty($guest->image->hash_name) ? url('storage/image/'.$guest->image->hash_name) : asset('admin/dist/img/default-user.png') }}" alt="User Avatar">
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{ $guest->reservation->where('status_id', 1)->count() }}</h5>
                  <span class="description-text" style="font-size: 11px;">Reserved</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{ $guest->reservation->where('status_id', 3)->count() }}</h5>
                  <span class="description-text" style="font-size: 11px;">Check In</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{ $guest->reservation->where('status_id', 4)->count() }}</h5>
                  <span class="description-text" style="font-size: 11px;">Check Out</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
              <div class="col-sm-3">
                <div class="description-block">
                  <h5 class="description-header">{{ $guest->reservation->where('status_id', 2)->count() }}</h5>
                  <span class="description-text" style="font-size: 11px;">Cancelled</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div>
        </div><!-- /.widget-user -->
      </div>
      <div class="col-lg-9 col-md-8">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Booking History</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
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
                    <th>Included Package</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Action</th>
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
                        @forelse($reservation->packages as $package)
                          {{ $package->amenity->name }}<br>
                          <small style="color: red;">
                            {{ Helper::get_owner_currency()->currency->symbol . ($package->price / $package->qty) }}&nbsp;x&nbsp;{{ $package->qty }}<br>
                          </small>
                        @empty
                          No Package
                        @endforelse
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