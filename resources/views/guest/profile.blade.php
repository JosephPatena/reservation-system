@extends('layout.guest')

@section('stylesheets')
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

  <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url('{{ Helper::get_contents()[0]->default ? asset('guest/images/big_image_1.jpg') : url('storage/image/' . Helper::get_contents()[0]->image->hash_name) }}');">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>My Profile</h1>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section" id="site-section">
      <div class="container">
        <div class="row">
              <div class="col-md-6">
                <h2 class="mb-5">Basic Info</h2>
                <form action="{{ route('update_profile') }}" method="post" enctype="multipart/form-data">
                  @csrf

                  <input type="hidden" name="id" value="{{ encrypt(Auth::id()) }}">
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <img class="change" src="{{ !empty(Helper::get_user()->image->hash_name) ? url('storage/image/'.Helper::get_user()->image->hash_name) : asset('admin/dist/img/default-user.png') }}" alt="User Avatar" data-toggle="tooltip" title="Click to Change Photo" style="cursor: pointer; height: 150px; width: 150px; border-radius: 50%;">
                      <input class="file" type="file" name="image" style="display: none;">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="name">Full Name</label>
                      <input type="text" id="name" class="form-control" name="name" required="" placeholder="Please enter your Full Name" value="{{ Auth::user()->name }}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="phone">Phone</label>
                      <input type="text" id="phone" class="form-control" name="phone" required="" placeholder="Please enter your Phone" value="{{ Auth::user()->phone }}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" class="form-control" name="email" required="" placeholder="Please enter your Email" value="{{ Auth::user()->email }}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <br>
                      <label for="toggle" style="cursor: pointer;">Change Password</label><br>
                      <label class="toggle">
                          <input class="toggle__input" name="change_pass" type="checkbox" id="toggle">
                          <div class="toggle__fill"></div>
                      </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="password">Password</label>
                      <input type="password" id="password" class="form-control" name="password" placeholder="Please enter your Password">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="confirm_password">Retype Password</label>
                      <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Please retype your Password">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 form-group">
                      <input type="submit" value="Update Profile" class="btn btn-primary">
                    </div>
                  </div>
                </form>
              </div>
        </div>
      </div>
    </section>
    <!-- END section -->
   
    <section class="section-cover" data-stellar-background-ratio="0.5" style="background-image: url('{{ Helper::get_contents()[2]->default ? asset('guest/images/img_5.jpg') : url('storage/image/' . Helper::get_contents()[2]->image->hash_name) }}');">
      <div class="container">
        <div class="row justify-content-center align-items-center intro">
          <div class="col-md-9 text-center element-animate">
            {!! Helper::get_contents()[2]->text !!}
            <div class='btn-play-wrap'><a href='{{ Helper::get_contents()[2]->link }}' class='btn-play popup-vimeo '><span class='ion-ios-play'></span></a></div>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

@endsection

@section('scripts')
  <script type="text/javascript">
    var pathname = window.location.pathname;
    var origin   = window.location.origin;
    window.location.href = origin + pathname + "#site-section"
    
    $('img.change').on('click', function(){
      $('input.file').click()
    })

    $('input.file').on('change', function(){
      if (event.target.files[0]) {
              $('img.change').attr("src", URL.createObjectURL(event.target.files[0]));
              return true;
      }
      $('img.change').attr("src", "{{ !empty(Helper::get_user()->image->hash_name) ? url('storage/image/'.Helper::get_user()->image->hash_name) : asset('admin/dist/img/default-user.png') }}");
        })
  </script>
@endsection