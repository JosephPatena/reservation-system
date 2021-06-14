@extends('layout.guest')

@section('content')

	<section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url({{ asset('guest/images/big_image_1.jpg') }});">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Our Rooms</h1>
              <p>Discover our world's #1 Luxury Room For VIP.</p>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->


    <section class="site-section" id="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-4">
            <div class="mb-5 element-animate" style="text-align: center;">
              <h1>401 Unathorized Access</h1>
              <p>Oops! The page you requested is not available at the moment.</p>
              <p>Please contact our support team or use the inquiry form for your concerns.</p>
              <p><a href="{{ route('contact') }}" class="btn btn-primary">Contact Us</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>

   
   

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

    <script type="text/javascript">
      window.location.href = window.location.href + "#site-section"
    </script>

@endsection