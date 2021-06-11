@extends('layout.guest')

@section('content')

	<section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url({{ asset('guest/images/big_image_1.jpg') }});">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Book Now</h1>
              <p>Discover our world's #1 Luxury Room For VIP.</p>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2 class="mb-5">Register</h2>
            <form action="{{ route('register_user') }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="name">Name</label>
                  <input type="text" id="name" class="form-control" value="{{ old('name') }}" name="name">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" class="form-control" value="{{ old('email') }}" name="email">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="phone">Phone</label>
                  <input type="text" id="phone" class="form-control" value="{{ old('phone') }}" name="phone">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="password">Password</label>
                  <input type="password" id="password" class="form-control" value="{{ old('password') }}" name="password">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="retype_password">Retype Password</label>
                  <input type="password" id="retype_password" class="form-control" value="{{ old('retype_password') }}" name="retype_password">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="submit" value="Login" class="btn btn-primary">
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-5">
            <h3 class="mb-5">Paragraph</h3>
            <p class="mb-5"><img src="{{ asset('guest/images/img_4.jpg') }}" alt="" class="img-fluid"></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae labore aspernatur cumque inventore voluptatibus odit doloribus! Ducimus, animi perferendis repellat. Ducimus harum alias quas, quibusdam provident ea sed, sapiente quo.</p>
            <p>Ullam cumque eveniet, fugiat quas maiores, non modi eos deleniti minima, nesciunt assumenda sequi vitae culpa labore nulla! Cumque vero, magnam ab optio quidem debitis dignissimos nihil nesciunt vitae impedit!</p>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="section-cover" data-stellar-background-ratio="0.5" style="background-image: url({{ asset('guest/images/img_5.jpg') }});">
      <div class="container">
        <div class="row justify-content-center align-items-center intro">
          <div class="col-md-9 text-center element-animate">
            <h2>Relax and Enjoy your Holiday</h2>
            <p class="lead mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto quidem tempore expedita facere facilis, dolores!</p>
            <div class="btn-play-wrap"><a href="https://vimeo.com/channels/staffpicks/93951774" class="btn-play popup-vimeo "><span class="ion-ios-play"></span></a></div>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

@endsection