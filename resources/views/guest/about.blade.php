@extends('layout.guest')

@section('content')

	<section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url('{{ Helper::get_contents()[0]->default ? asset('guest/images/big_image_1.jpg') : url('storage/image/' . Helper::get_contents()[0]->image->hash_name) }}');">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>About Us</h1>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section" id="site-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-4">
            {!! Helper::get_contents()[3]->text !!}
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-7">
            <img src="{{ Helper::get_contents()[3]->default ? asset('guest/images/f_img_1.png') : url('storage/image/' . Helper::get_contents()[3]->image->hash_name) }}" alt="Image placeholder" class="img-md-fluid">
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
      var pathname = window.location.pathname;
      var origin   = window.location.origin;
      window.location.href = origin + pathname + "#site-section"
    </script>

@endsection