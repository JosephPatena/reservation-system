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
      Guest
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-users"></i> Guest</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <!-- Guest -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date Registered</th>
                    <th>Access</th>
                    <th>Reserved</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Cancelled</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($guest as $key => $guest)
                    <tr>
                      <td>{{ $key+1 }}.</td>
                      <td>
                        <img style="width: 25px; height: 25px; cursor: pointer;" src="{{ !empty($guest->image->hash_name) ? url('storage/image/'.$guest->image->hash_name) : asset('admin/dist/img/default-user.png') }}" alt="Guest Image">
                      </td>
                      <td>{{ $guest->name }}</td>
                      <td>{{ $guest->email }}</td>
                      <td>{{ $guest->phone }}</td>
                      <td>{{ \Carbon\Carbon::parse($guest->created_at)->format('F d Y h:i A') }}</td>
                      <td>
                        @if($guest->restricted)
                          <span class="badge bg-red">Restricted</span>
                        @else
                          <span class="badge bg-green">Unrestricted</span>
                        @endif
                      </td>
                      <td>{{ $guest->reservation->where('status_id', 1)->count() }}</td>
                      <td>{{ $guest->reservation->where('status_id', 2)->count() }}</td>
                      <td>{{ $guest->reservation->where('status_id', 3)->count() }}</td>
                      <td>{{ $guest->reservation->where('status_id', 4)->count() }}</td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-primary btn-sm">Action</button>
                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('guest', $guest->id) }}">View Reports</a></li>
                            @if($guest->restricted)
                              <li><a class="unrestrict" href="{{ route('unrestrict_user', encrypt($guest->id)) }}">Unrestrict Access</a></li>
                            @else
                              <li><a class="restrict" href="{{ route('restrict_user', encrypt($guest->id)) }}">Restrict Access</a></li>
                            @endif
                            
                          </ul>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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

    $('a.restrict').on('click', function(evt){
      evt.preventDefault()
      let check = confirm("Are you sure you want to restrict this user?")
      if (check) {
        $(this).unbind('click')
        evt.currentTarget.click();
      }
    })

    $('a.unrestrict').on('click', function(evt){
      evt.preventDefault()
      let check = confirm("Are you sure you want to unrestrict this user?")
      if (check) {
        $(this).unbind('click')
        evt.currentTarget.click();
      }
    })
  </script>
@endsection