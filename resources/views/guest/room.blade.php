@extends('layout.guest')

@section('content')

	<section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url('{{ Helper::get_contents()[0]->default ? asset('guest/images/big_image_1.jpg') : url('storage/image/' . Helper::get_contents()[0]->image->hash_name) }}');">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Checkout our Rooms</h1>
              <p><a href="{{ route('reservation.create') }}" class="btn btn-primary">Book Now</a></p>
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
                        <li style="cursor: pointer;" data-target="#carouselExampleIndicators{{ $index }}" data-slide-to="{{ $key }}" class="{{ $key==0 ? "active" : "" }}"></li>
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