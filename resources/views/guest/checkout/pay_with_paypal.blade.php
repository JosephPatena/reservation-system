@extends('layout.guest')

@section('content')
  
  <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Reservation</h1>
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
          <div class="col-md-8">
            <h2 class="mb-5">Payment Details</h2>
            <form action="{{ route('reservation.store') }}" method="post">
              @csrf

              <div class="row">
                <div class="col-sm-12 form-group">
                  <table class="table table table-striped table-condensed table-bordered">
                    <thead>
                      <tr>
                        <th>ROOM TYPE</th>
                        <th>MAX GUEST</th>
                        <th>NO OF ROOM</th>
                        <th>PRICE</th>
                        <th>LENGTH STAY (day)</th>
                        <th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{ $room->accomodation->name }}</td>
                        <td>{{ $room->no_of_person }}</td>
                        <td>{{ $room->no_of_room }}</td>
                        <td>{{ Helper::get_owner_currency()->currency->symbol . number_format($room->price, 2) }}</td>
                        <td>{{ $length_stay }}</td>
                        <td>{{ Helper::get_owner_currency()->currency->symbol . number_format(($room->price * $length_stay), 2) }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                
                <div class="col-sm-8 form-group">
                    <label for="">Arrival Date and Departure Date</label>
                    <div style="position: relative;">
                      <input style="border-color: lime; color: lime" type='text' class="form-control" value="{{ Session::get('date_range') }}">
                    </div>
                    <label class="status" style="color: lime"><i class="ion-checkmark">&nbsp;&nbsp;Available</i></label>
                </div>

                <div class="col-sm-4">
                  <h4 style="float: right; border: solid thin red; padding: 15px; font-family: Courier;">Total <br>{{ Helper::get_owner_currency()->currency->symbol . number_format(($room->price * $length_stay), 2) }}</h4>
                </div>

                <div class="col-sm-8 form-group">
                  <div id="paypal-button-container"></div>
                </div>
              </div>

              <input type="hidden" name="room_id" value="{{ encrypt($room->id) }}">
            </form>
          </div>
          <div class="col-md-4">
            <h3 class="mb-5"><a href="{{ route('room_type', $room->accomodation_id) }}">{{ $room->accomodation->name }}</a></h3>
            <div class="media d-block room mb-0">
              <figure>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    @foreach($room->images as $key => $image)
                      <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ $key==0 ? "active" : "" }}"></li>
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
                  <li><span class="ion-ios-crop"></span> {{ $room->no_of_room }} Room</li>
                </ul>
                {!! $room->description !!}
                <p><a href="#" class="btn btn-primary btn-sm">Total {{ Helper::get_owner_currency()->currency->symbol . number_format($room->price, 2) }}</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="section-cover" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/img_5.jpg);">
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

@section('scripts')
  <script src="https://www.paypal.com/sdk/js?client-id={{ $payment_method->public_key }}&currency={{ Helper::get_owner_currency()->currency->iso_code }}"></script>
  <script>
    window.location.href = window.location.href + "#site-section"

    paypal.Buttons({
      // Call your server to set up the transaction
      createOrder: function(data, actions) {
          return fetch('{{ route('paypal.create_order') }}', {
              method: 'post',
              headers: {
                'content-type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
              }
          }).then(function(res) {
              return res.json();
          }).then(function(orderData) {
              return orderData.id;
          });
      },

      // Call your server to finalize the transaction
      onApprove: function(data, actions) {
          return fetch('{{ route('paypal.capture_order', '') }}/' + data.orderID, {
              method: 'post',
              headers: {
                'content-type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
              }
          }).then(function(res) {
              return res.json();
          }).then(function(response) {
              // Three cases to handle:
              //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
              //   (2) Other non-recoverable errors -> Show a failure message
              //   (3) Successful transaction -> Show confirmation or thank you

              var orderData = response[0];

              // This example reads a v2/checkout/orders capture response, propagated from the server
              // You could use a different API or structure for your 'orderData'
              var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

              if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                  return actions.restart(); // Recoverable state, per:
                  // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
              }

              if (errorDetail) {
                  var msg = 'Sorry, your transaction could not be processed.';
                  if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                  if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                  return alert(msg); // Show a failure message
              }

              // Redirect success page
              if (response[1] == 200) {
                window.open("{{ route('setup_completion') }}", "_self")
              }
          });
      }
    }).render('#paypal-button-container');
    //This function displays Smart Payment Buttons on your web page.
  </script>
@endsection