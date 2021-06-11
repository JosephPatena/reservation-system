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


    <section class="site-section">
      <div class="container">
        <div class="row">
          @foreach($rooms as $room)
            <div class="col-md-4 mb-4">
              <div class="media d-block room mb-0">
                <figure>
                  <img src="{{ url('storage/image/'.$room->images->first()->hash_name) }}" alt="Room Image" class="img-fluid">
                  <div class="overlap-text">
                    <span>
                      <span class="ion-ios-star"></span>
                      <span class="ion-ios-star"></span>
                      <span class="ion-ios-star"></span>
                    </span>
                  </div>
                </figure>
                <div class="media-body">
                  <h3 class="mt-0"><a href="{{ route('room_type', $room->accomodation_id) }}">{{ $room->accomodation->name }}</a></h3>
                  <ul class="room-specs">
                    <li><span class="ion-ios-people-outline"></span> {{ $room->no_of_person }} Guests</li>
                    <li><span class="ion-ios-bed-outline"></span> {{ $room->no_of_room }} Room</li>
                  </ul>
                  {!! $room->description !!}
                  <p><a href="{{ route('reservation_create', $room->id) }}" class="btn btn-primary btn-sm">Book Now From {{ Helper::get_owner_currency()->currency->symbol . number_format($room->price, 2) }}</a></p>
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

@endsection