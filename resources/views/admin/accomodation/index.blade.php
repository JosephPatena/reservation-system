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
      Accomodation
      <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-star"></i> Accomodation</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
		<div class="row">
      <div class="col-xs-4">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Accomodation</h3>
            </div><!-- /.box-header -->
            <form action="{{ route('accomodation.store') }}" method="post">
              @csrf
              <div class="box-body">
                <div class="form-horizontal">

                  <div class="form-group">
                    <label for="inputAccomodation" class="col-sm-4 control-label">Accomodation <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                      <input name="name" type="text" class="form-control" id="inputAccomodation" placeholder="Accomodation" required="" value="{{ old('name') }}">
                    </div>
                  </div> 

                  <div class="form-group">
                    <label for="inputDesc" class="col-sm-4 control-label">Description <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                      <input name="description" type="text" class="form-control" id="inputDesc" placeholder="Description" required="" value="{{ old('description') }}">
                    </div>
                  </div> 

                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button class="btn btn-success btn-sm" style="float: right;">Save and Refresh</button>
              </div>
            </form>
          </div><!-- /.box -->
      </div>
		  <div class="col-xs-8">

		      <div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">List</h3>
		        </div><!-- /.box-header -->
		        <div class="box-body">
		          <table id="example1" class="table table-bordered table-striped">
		            <thead>
		              <tr>
		                <th>Accomodation</th>
		                <th>Description</th>
		                <th>Action</th>
		              </tr>
		            </thead>
		            <tbody>
		            	@foreach($accomodation as $value)
		            		<tr>
		            			<td>
                        <span>{{ $value->name }}</span>
                        <input value="{{ $value->name }}" style="display: none" class="form-control name">
                      </td>
		            			<td>
                        <span>{{ $value->description }}</span>
                        <input value="{{ $value->description }}" style="display: none" class="form-control description">
                      </td>
                      <form action="{{ route('accomodation.destroy', $value->id) }}" method="post" class="delete">
                        @csrf
                        @method('DELETE')
	            			    <td class="btn-group">
  		            				<button type="button" class="btn btn-primary btn-sm edit"><i class="fa fa-edit"></i></button>
                          <button type="button" class="btn btn-success btn-sm save" data-id="{{ $value->id }}" style="display: none;"><i class="fa fa-save"></i></button>
  		            				<button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>
	            			    </td>
                      </form>
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

    $('button.edit').on('click', function(){
      let element = $(this)
      element.parent().siblings().find('input').show()
      element.parent().siblings().find('span').hide()
      element.siblings('button.save').show()
      element.hide()
    })

    $('button.save').on('click', function(){
      let element = $(this)
      $.ajax({
        url: '{{ route('accomodation.update', '') }}/'+element.data('id'),
        data: {
          name: element.parent().siblings().find('input.name').val(),
          description: element.parent().siblings().find('input.description').val()
        },
        dataType: 'json',
        type: 'post',
        type: 'put'
      })
      .done(function(){
        toastr.success("Accomodation updated successfully.")
        window.location.reload(true)
      })
      .fail(function(){
        toastr.error("Failed! Something went wrong")
      })
    })

    $('button.delete').on('click', function(evt){
      evt.preventDefault()
      let element = $(this)
      let check = confirm("Are you sure you want to delete this item?")
      if (check) {
        element.unbind('click')
        evt.currentTarget.click();
      }
    })
  </script>
@endsection