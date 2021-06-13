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
      Guest Inquiries
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-comment-o"></i> Guest Inquiries</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-8">
        <!-- Chat box -->
        @foreach($inquiries as $value)
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comment-o"></i>
              <h3 class="box-title">Inquiry</h3>
            </div>
            <div class="box-body chat" id="chat-box">
              <!-- chat item -->
              <div class="item">
                <img src="{{ (!empty($value->guest->image->hash_name) && $value->same_as_profile) ? url('storage/image/'.$value->guest->image->hash_name) : asset('admin/dist/img/default-user.png') }}" alt="user image" class="online">
                <p class="message">
                  <a href="{{ route('guest', $value->guest->id) }}" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{ $value->created_at }}</small>
                    {{ $value->name }}
                  </a>
                  {{ $value->message }}
                </p>
                @if($value->response)
                <div class="attachment">
                  <h4>Response from Support:</h4>
                  <p class="filename">
                    {{ $value->response }}
                  </p>
                </div><!-- /.attachment -->
                @endif
              </div><!-- /.item -->
            </div><!-- /.chat -->
            <div class="box-footer">
              <form action="{{ route('inquiries.update', $value->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="input-group">
                  <input class="form-control" placeholder="Your response..." name="response" required="">
                  <div class="input-group-btn">
                    <button class="btn btn-success"><i class="fa fa-send"></i>&nbsp;&nbsp;Save or Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div><!-- /.box (chat box) -->
        @endforeach
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
  </script>
@endsection