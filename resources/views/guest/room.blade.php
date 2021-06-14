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
          @foreach($rooms as $index => $room)
            <div class="col-md-4 mb-4">
              <div class="media d-block room mb-0">
                <figure>
                  <div id="carouselExampleIndicators{{ $index }}" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      @foreach($room->images as $key => $image)
                        <li data-target="#carouselExampleIndicators{{ $index }}" data-slide-to="{{ $key }}" class="{{ $key==0 ? "active" : "" }}"></li>
                      @endforeach
                    </ol>
                    <div class="carousel-inner">
                      @foreach($room->images as $key => $image)
                        <div class="carousel-item {{ $key==0 ? "active" : "" }}">
                          <img class="d-block w-100" src="{{ url('storage/image/' . $image->hash_name) }}" alt="Room Image">
                        </div>
                      @endforeach
                    </div>
                  </div>
                </figure>
                <div class="media-body">
                  <h3 class="mt-0"><a href="{{ route('room_details', $room->id) }}">{{ $room->name }}</a></h3>
                  <ul class="room-specs">
                    <li><span class="ion-ios-people-outline"></span> {{ $room->no_of_person }} Guests</li>
                    <li><span class="ion-ios-bed-outline"></span> {{ $room->no_of_room }} Room</li>
                  </ul>
                  {!! $room->description !!}
                  <p><a href="{{ route('reservation_create', $room->id) }}" class="btn btn-primary btn-sm" {{ !$room->is_available ? "disabled" : "" }}>Book Now From {{ Helper::get_owner_currency()->currency->symbol . number_format($room->price, 2) }}</a></p>
                </div>
              </div>
            </div>
          @endforeach
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