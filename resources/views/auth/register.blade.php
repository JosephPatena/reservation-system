@extends('layout.guest')

@section('stylesheets')
  <style type="text/css">
    .form-group {
      display: block;
      margin-bottom: 15px;
    }

    .form-group .input {
      padding: 0;
      height: initial;
      width: initial;
      margin-bottom: 0;
      display: none;
      cursor: pointer;
    }

    .form-group .label {
      position: relative;
      cursor: pointer;
    }

    .form-group .label:before {
      content: "";
      -webkit-appearance: none;
      background-color: transparent;
      border: 2px solid #c29200;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05),
        inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
      padding: 10px;
      display: inline-block;
      position: relative;
      vertical-align: middle;
      cursor: pointer;
      margin-right: 5px;
    }

    .form-group .input:checked + .label:after {
      content: "";
      display: block;
      position: absolute;
      top: 2px;
      left: 9px;
      width: 6px;
      height: 14px;
      border: solid #c29200;
      border-width: 0 2px 2px 0;
      transform: rotate(45deg);
    }
  </style>
@endsection

@section('content')

	<section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url('{{ Helper::get_contents()[0]->default ? asset('guest/images/big_image_1.jpg') : url('storage/image/' . Helper::get_contents()[0]->image->hash_name) }}');">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Register Now</h1>
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
            <h2 class="mb-5">Register</h2>
            <form action="{{ route('register_user') }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 form-group">
                  <div class="form-group">
                    <label for="terms">Already have an account? <a href="{{ route('login') }}">Login instead</a></label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="name">Name</label>
                  <input type="text" id="name" class="form-control" value="{{ old('name') }}" name="name" placeholder="Please enter your Full Name" required="">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" class="form-control" value="{{ old('email') }}" name="email" placeholder="Please enter your Email" required="">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="phone">Phone</label>
                  <input type="text" id="phone" class="form-control" value="{{ old('phone') }}" name="phone" placeholder="Please enter your Phone" required="">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="password">Password</label>
                  <input type="password" id="password" class="form-control" value="{{ old('password') }}" name="password" placeholder="Please enter your Password" required="">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="retype_password">Retype Password</label>
                  <input type="password" id="retype_password" class="form-control" value="{{ old('retype_password') }}" name="retype_password" placeholder="Please retype your Password" required="">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <div class="form-group">
                    <input type="checkbox" id="terms" class="input" name="terms_and_condition" required="">
                    <label for="terms" class="label"><a href="{{ route('terms_and_condition.show', 1) }}">Terms and Condition</a></label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="submit" value="Register" class="btn btn-primary">
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

    <script type="text/javascript">
      window.location.href = window.location.href + "#site-section"
    </script>

@endsection