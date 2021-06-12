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
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

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
            <div class="widget-user-header">
              <form action="{{ route('rooms.update', $room->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-horizontal">

                  <label for="inputRoomNo" class="control-label">Room No <span style="color: red;">*</span></label>
                  <input name="room_no" type="text" class="form-control" id="inputRoomNo" placeholder="Room No" required="" value="{{ $room->no }}">
                  
                  <label for="inputRoom" class="control-label">Room Name <span style="color: red;">*</span></label>
                  <input name="name" type="text" class="form-control" id="inputRoom" placeholder="Room Name" required="" value="{{ $room->name }}">
                
                  <label for="inputDesc" class="control-label">Description <span style="color: red;">*</span></label>
                  <textarea name="description" class="textarea" id="inputDesc" placeholder="Room Description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required="">{{ $room->description }}</textarea>
                    
                  <label for="inputAccomodation" class="control-label">Accomodation <span style="color: red;">*</span></label>
                  <select name="accomodation_id" class="form-control" id="inputAccomodation" required="">
                    <option value="">Choose Accomodation Type</option>
                    @foreach($accomodation as $value)
                      <option value="{{ $value->id }}" {{ $room->accomodation_id == $value->id ? "selected" : "" }}>{{ $value->name }}</option>
                    @endforeach
                  </select>

                  <label for="inputNoPerson" class="control-label">Max Guest <span style="color: red;">*</span></label>
                  <input name="max_guest" type="number" class="form-control" id="inputNoPerson" placeholder="No. of Person" required="" value="{{ $room->max_guest }}">

                  <label for="inputPrice" class="control-label">Price <span style="color: red;">*</span></label>
                  <input name="price" type="number" class="form-control" id="inputPrice" placeholder="Price" required="" value="{{ $room->price }}">

                  <label for="inputNoRoom" class="control-label">No. of Room <span style="color: red;">*</span></label>
                  <input name="no_of_room" type="number" class="form-control" id="inputNoRoom" placeholder="No. of Room" required="" value="{{ $room->no_of_room }}">

                  <label for="inputNoRoom" class="control-label">Max length of Stay (day) <span style="color: red;">*</span></label>
                  <input name="max_length_stay" type="number" class="form-control" id="inputNoRoom" placeholder="No. of Room" required="" value="{{ $room->max_length_stay }}">

                  <label class="toggle" style="padding-top: 10px">
                      <span for="toggle" class="control-label" style="cursor: pointer;">Available</span>
                      <input class="toggle__input" name="is_available" type="checkbox" id="toggle">
                      <div class="toggle__fill"></div>
                  </label>

                  <button type="submit" class="btn btn-success btn-sm" style="float: right; margin-top: 20px">Update and Refresh</button> <br>
                </div>
              </form>
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
              <button class="btn btn-default btn-sm" style="float: right;" data-toggle="modal" data-target="#add-new-photo"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add New Photo</button>
              <div class="modal fade" id="add-new-photo">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Add New Photo</h4>
                    </div>
                    <form action="{{ route('store_image') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <div class="form-horizontal">

                          <div class="form-group">
                            <label for="fileUpload" class="col-sm-2 control-label">Upload Image <span style="color: red;">*</span></label>
                            <div class="col-sm-10">
                              <input multiple="" name="photos[]" type="file" class="form-control" id="fileUpload" placeholder="Please select image">
                              <span id="photos-preview"></span>
                            </div>
                          </div>

                          <input type="hidden" name="room_id" value="{{ $room->id }}">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save and Close</button>
                      </div>
                    </form>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class='row'>
                  @foreach($room->images as $image)
                    <div class='col-sm-3 margin-bottom animate__animated animate__pulse animate__slower'>
                      <form action="{{ route('delete_image') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ encrypt($image->id) }}">
                      </form>
                      <i class="fa fa-trash-o delete-img" style="position: absolute; font-size:18px; margin:10px; color: red; cursor:pointer;" title="Remove"></i>
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
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{ asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
  <script>
    $(function () {
      //bootstrap WYSIHTML5 - text editor
      $(".textarea").wysihtml5();
    });

    $('#fileUpload').on('change', function(){
        $('#photos-preview').html("");

        var total_file=document.getElementById("fileUpload").files.length;
        for(var i=0;i<total_file;i++){
            $('#photos-preview').append("<img style='width:50px; height:50px; cursor: pointer; border-radius: 5px' src='"+URL.createObjectURL(event.target.files[i])+"'>&nbsp;");
        }
    })

    $('.delete-img').on('click', function(){
      let check = confirm("Are you sure you want to delete?")
      if (check) {
        $(this).siblings('form').submit()
      }
    })
  </script>
@endsection