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
      Room
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-star"></i> Room</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
    	<div class="col-lg-12">
        <button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#add-new"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;Add New Room</button>
        <div class="modal fade" id="add-new">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Room</h4>
              </div>
              <form action="{{ route('rooms.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class="form-horizontal">

                    <div class="form-group">
                      <label for="inputRoomNo" class="col-sm-2 control-label">Room No <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <input name="no" type="text" class="form-control" id="inputRoomNo" placeholder="Room No" required="" value="{{ old('no') }}">
                      </div>
                    </div> 
                    
                    <div class="form-group">
                      <label for="inputRoom" class="col-sm-2 control-label">Room Name <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <input name="name" type="text" class="form-control" id="inputRoom" placeholder="Room Name" required="" value="{{ old('name') }}">
                      </div>
                    </div> 

                    <div class="form-group">
                      <label for="inputDesc" class="col-sm-2 control-label">Description <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <textarea name="description" class="textarea" id="inputDesc" placeholder="Room Description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required="">{{ old('description') }}</textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputAccomodation" class="col-sm-2 control-label">Accomodation <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <select name="accomodation_id" class="form-control" id="inputAccomodation" required="">
                          <option value="">Choose Accomodation Type</option>
                          @foreach($accomodation as $value)
                            <option value="{{ $value->id }}" {{ old('accomodation_id') == $value->id ? "selected" : "" }}>{{ $value->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputNoPerson" class="col-sm-2 control-label">Max Guest <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <input name="max_guest" type="number" class="form-control" id="inputNoPerson" placeholder="No. of Person" required="" value="{{ old('max_guest') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputPrice" class="col-sm-2 control-label">Price <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <input name="price" type="number" class="form-control" id="inputPrice" placeholder="Price" required="" value="{{ old('price') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputNoRoom" class="col-sm-2 control-label">No. of Room <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <input name="no_of_room" type="number" class="form-control" id="inputNoRoom" placeholder="No. of Room" required="" value="{{ old('no_of_room') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputMax" class="col-sm-2 control-label">Max length of Stay (day) <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <input name="max_length_stay" type="number" class="form-control" id="inputMax" placeholder="No. of Room" required="" value="{{ old('max_length_stay') }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="fileUpload" class="col-sm-2 control-label">Upload Image <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <input multiple="" name="photos[]" type="file" class="form-control" id="fileUpload" placeholder="Please select image">
                        <span id="photos-preview"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="fileUpload" class="col-sm-2 control-label">Available <span style="color: red;">*</span></label>
                      <div class="col-sm-10">
                        <label class="toggle">
                            <input class="toggle__input" name="is_available" type="checkbox">
                            <div class="toggle__fill"></div>
                        </label>
                      </div>
                    </div>

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
      </div>
      @foreach($rooms as $key => $value)
        <div class="col-lg-3 col-xs-6">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-default">
            
              <h3><small>Room <br> No.</small> <b>{{ $value->no }}</b></h3>
              <i class="fa fa-folder-open-o open-url" data-url="{{ route('rooms.show', $value->id) }}" style="float: right; cursor: pointer;" data-toggle="tooltip" title="View / Edit details"></i>
              <h5>{{ $value->name }} &nbsp;&nbsp;
                @if(!$value->is_available)
                  <span class="label bg-maroon">Under Maintenance</span>
                @endif
              </h5>
            </div>
            <div id="carousel-example-generic-{{ $key }}" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                @foreach($value->images as $index => $image)
                  <li data-target="#carousel-example-generic-{{ $index }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? "active" : "" }}"></li>
                @endforeach
              </ol>
              <div class="carousel-inner">
                @foreach($value->images as $index => $image)
                <div class="item {{ $index == 0 ? "active" : "" }}">
                  <img src="{{ url('storage/image/' . $image->hash_name) }}" alt="{{ $value->accomodation->name }}">
                  <div class="carousel-caption">
                    {{ $value->accomodation->name }}
                  </div>
                </div>
                @endforeach
              </div>
              <a class="left carousel-control" href="#carousel-example-generic-{{ $key }}" data-slide="prev">
                <span class="fa fa-angle-left"></span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic-{{ $key }}" data-slide="next">
                <span class="fa fa-angle-right"></span>
              </a>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="{{ route('room_reports', $value->id) }}"><center>View Reports</center></a></li>
              </ul>
            </div>
          </div><!-- /.widget-user -->
        </div><!-- ./col -->
      @endforeach
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

    $('#fileUpload').on('change', function(){
        $('#photos-preview').html("");

        var total_file=document.getElementById("fileUpload").files.length;
        for(var i=0;i<total_file;i++){
            $('#photos-preview').append("<img style='width:50px; height:50px; cursor: pointer; border-radius: 5px' src='"+URL.createObjectURL(event.target.files[i])+"'>&nbsp;");
        }
    })
  </script>
@endsection