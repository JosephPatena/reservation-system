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
      Content
      <small>Management</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-cog"></i> Content</a></li>
      <li class="active">Management</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-7 col-xs-12">
          <!-- Widget: user widget style 1 -->
          <div class="box">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-header">
              <h3>Homepage Section</h3>
              <h5>Homepage Section</h5>
            </div>
            <hr>
            <form action="{{ route('content.update', $contents[0]->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="has_image" value="{{ true }}">
              <div class="box-body">
                <label>HOMEPAGE BANNER</label><br>
                <input class="file" type="file" name="image" style="display: none;">
                <img class="change" style="cursor: pointer; width: 100%; height: 100%;" data-toggle="tooltip" title="Click to Change Photo" data-old="{{ $contents[0]->default ? asset('guest/images/big_image_1.jpg') : url('storage/image/' . $contents[0]->image->hash_name) }}" src="{{ $contents[0]->default ? asset('guest/images/big_image_1.jpg') : url('storage/image/' . $contents[0]->image->hash_name) }}"><br><br>
                <label>HOMEPAGE TEXT</label><br>
                <textarea name="text" class="textarea" placeholder="Homepage text" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $contents[0]->text }}</textarea>
              </div>
              <div class="box-footer">
                <button class="btn btn-success btn-sm pull-right">Update Content</button>
              </div>
            </form>
          </div><!-- /.widget-user -->

          <div class="box">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-header">
              <h3>Introduction Section</h3>
              <h5>Introduction Section</h5>
            </div>
            <hr>
            <form action="{{ route('content.update', $contents[1]->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="has_image" value="{{ true }}">
              <div class="box-body">
                <label>INTRODUCTION BANNER</label><br>
                <input class="file" type="file" name="image" style="display: none;">
                <img class="change" style="cursor: pointer; width: 100%; height: 100%;" data-toggle="tooltip" title="Click to Change Photo" data-old="{{ $contents[1]->default ? asset('guest/images/f_img_1.png') : url('storage/image/' . $contents[1]->image->hash_name) }}" src="{{ $contents[1]->default ? asset('guest/images/f_img_1.png') : url('storage/image/' . $contents[1]->image->hash_name) }}"><br><br>
                <label>INTRODUCTION TEXT</label><br>
                <textarea name="text" class="textarea" placeholder="Introduction text" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $contents[1]->text }}</textarea>
              </div>
              <div class="box-footer">
                <button class="btn btn-success btn-sm pull-right">Update Content</button>
              </div>
            </form>
          </div><!-- /.widget-user -->

          <div class="box">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-header">
              <h3>Video Teaser Section</h3>
              <h5>Video Teaser Section</h5>
            </div>
            <hr>
            <form action="{{ route('content.update', $contents[2]->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="has_image" value="{{ true }}">
              <div class="box-body">
                <label>VIDEO TEASER BANNER</label><br>
                <input class="file" type="file" name="image" style="display: none;">
                <img class="change" style="cursor: pointer; width: 100%; height: 100%;" data-toggle="tooltip" title="Click to Change Photo" data-old="{{ $contents[2]->default ? asset('guest/images/img_5.jpg') : url('storage/image/' . $contents[2]->image->hash_name) }}" src="{{ $contents[2]->default ? asset('guest/images/img_5.jpg') : url('storage/image/' . $contents[2]->image->hash_name) }}"><br><br>
                <label>VIDEO TEASER TEXT</label><br>
                <textarea name="text" class="textarea" placeholder="Video teaser text" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $contents[2]->text }}</textarea>
                <label>VIDEO TEASER LINK</label><br>
                <input type="text" name="link" class="form-control" value="{{ $contents[2]->link }}" placeholder="Video teaser link">
              </div>
              <div class="box-footer">
                <button class="btn btn-success btn-sm pull-right">Update Content</button>
              </div>
            </form>
          </div><!-- /.widget-user -->

          <div class="box">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-header">
              <h3>About Us Section</h3>
              <h5>About Us Section</h5>
            </div>
            <hr>
            <form action="{{ route('content.update', $contents[3]->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="has_image" value="{{ true }}">
              <div class="box-body">
                <label>ABOUT US BANNER</label><br>
                <input class="file" type="file" name="image" style="display: none;">
                <img class="change" style="cursor: pointer; width: 100%; height: 100%;" data-toggle="tooltip" title="Click to Change Photo" data-old="{{ $contents[3]->default ? asset('guest/images/f_img_1.png') : url('storage/image/' . $contents[3]->image->hash_name) }}" src="{{ $contents[3]->default ? asset('guest/images/f_img_1.png') : url('storage/image/' . $contents[3]->image->hash_name) }}"><br><br>
                <label>ABOUT US TEXT</label><br>
                <textarea name="text" class="textarea" placeholder="About Us text" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $contents[3]->text }}</textarea>
              </div>
              <div class="box-footer">
                <button class="btn btn-success btn-sm pull-right">Update Content</button>
              </div>
            </form>
          </div><!-- /.widget-user -->

          <!-- Widget: user widget style 1 -->
          <div class="box">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-header">
              <h3>Contact Details</h3>
            </div>
            <form action="{{ route('content.update', $contents[4]->id) }}" method="post">
              @csrf
              <div class="box-body">
                  @method('PUT')
                  <div class="form-horizontal">
                    <div class="form-group">
                      <label for="inputPhone" class="col-sm-2 control-label">Phone</label>
                      <div class="col-sm-10">
                        <input style="width: 50%" name="phone" type="text" class="form-control" id="inputPhone" placeholder="Phone" value="{{ $contents[4]->phone }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputFB" class="col-sm-2 control-label">Facebook link</label>
                      <div class="col-sm-10">
                        <input style="width: 50%" name="facebook_link" type="text" class="form-control" id="inputFB" placeholder="Facebook link" value="{{ $contents[4]->facebook_link }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputTwitter" class="col-sm-2 control-label">Twitter link</label>
                      <div class="col-sm-10">
                        <input style="width: 50%" name="twitter_link" type="text" class="form-control" id="inputTwitter" placeholder="Twitter link" value="{{ $contents[4]->twitter_link }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputInsta" class="col-sm-2 control-label">Instagram link</label>
                      <div class="col-sm-10">
                        <input style="width: 50%" name="instagram_link" type="text" class="form-control" id="inputInsta" placeholder="Instagram link" value="{{ $contents[4]->instagram_link }}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputYT" class="col-sm-2 control-label">YouTube link</label>
                      <div class="col-sm-10">
                        <input style="width: 50%" name="youtube_link" type="text" class="form-control" id="inputYT" placeholder="YouTube link" value="{{ $contents[4]->youtube_link }}">
                      </div>
                    </div>
                  </div>
              </div>
              <div class="box-footer">
                <button class="btn btn-success btn-sm pull-right">Update Content</button>
              </div>
            </form>
          </div><!-- /.widget-user -->
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
  <!-- page script -->
  <script>
    $(".textarea").wysihtml5();

    $('img.change').on('click', function(){
      $(this).siblings('input.file').click()
    })

    $('input.file').on('change', function(){
      if (event.target.files[0]) {
        $(this).siblings('img.change').attr("src", URL.createObjectURL(event.target.files[0]));
        return true;
      }
      $(this).siblings('img.change').attr("src", $(this).siblings('img.change').data('old'));
    })
  </script>
@endsection