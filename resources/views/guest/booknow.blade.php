@extends('layout.guest')

@section('stylesheets')
  <style type="text/css">
    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
      position: absolute;
      left: -9999px;
    }
    [type="radio"]:checked + label,
    [type="radio"]:not(:checked) + label {
      position: relative;
      padding-left: 28px;
      cursor: pointer;
      line-height: 20px;
      display: inline-block;
      color: #666;
    }
    [type="radio"]:checked + label:before,
    [type="radio"]:not(:checked) + label:before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      width: 18px;
      height: 18px;
      border: 1px solid #ddd;
      border-radius: 100%;
      background: #fff;
    }
    [type="radio"]:checked + label:after,
    [type="radio"]:not(:checked) + label:after {
      content: "";
      width: 12px;
      height: 12px;
      background: #d2b55b;
      position: absolute;
      top: 4px;
      left: 4px;
      border-radius: 100%;
      -webkit-transition: all 0.2s ease;
      transition: all 0.2s ease;
    }
    [type="radio"]:not(:checked) + label:after {
      opacity: 0;
      -webkit-transform: scale(0);
      transform: scale(0);
    }
    [type="radio"]:checked + label:after {
      opacity: 1;
      -webkit-transform: scale(1);
      transform: scale(1);
    }

  </style>
@endsection

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

    <section class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <h2 class="mb-5">Reservation Form</h2>
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
                        <th>LENGTH OF STAY (DAY)</th>
                        <th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>{{ $room->accomodation->name }}</td>
                        <td>{{ $room->max_guest }}</td>
                        <td>{{ $room->no_of_room }}</td>
                        <td>{{ Helper::get_owner_currency()->currency->symbol . number_format($room->price, 2) }}</td>
                        <td>{{ $room->max_length_stay }}</td>
                        <td>{{ Helper::get_owner_currency()->currency->symbol . number_format($room->price, 2) }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                
                <div class="col-sm-8 form-group">
                    <label for="">Please choose Arrival and Departure Date</label>
                    <div style="position: relative;">
                      <input type='text' class="form-control date-range" id="demo" name="date_range" required="">
                    </div>
                    <label class="status"></label>
                </div>

              </div>

              <div class="row">
                <div class="col-md-12 col-sm-12">
                  @foreach(Helper::get_payment_method() as $key => $payment_method)
                  <p>
                    <input type="radio" id="option-{{ $key }}" name="payment_method_id" value="{{ encrypt($payment_method->id) }}" required="" {{ !$payment_method->is_available ? "disabled" : "" }}>
                    <label for="option-{{ $key }}">
                      <b style="font-weight: bold;">{{ $payment_method->name }}</b><br>
                      {{ $payment_method->description }}
                      @if(!$payment_method->is_available)
                        <br><span style="color: #d2b55b">Not available a the moment.</span>
                      @endif
                    </label>
                  </p>
                  @endforeach
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="submit" value="Reserve Now" class="btn btn-primary" disabled="">
                </div>
              </div>

              <input type="hidden" name="room_id" value="{{ encrypt($room->id) }}">
            </form>
          </div>
          <div class="col-md-4">
            <h3 class="mb-5">Room</h3>
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
  <script type="text/javascript">

    $('input.date-range').on('change', function(){
      let element = $(this)

      $.ajax({
        url: "{{ route('check_availability') }}",
        type: "post",
        dataType: "json",
        data: {
          room_id: "{{ encrypt($room->id) }}",
          date_range: element.val()
        }
      })
      .done(function(res){
        if (res.status) {
          element.css({'border-color':'lime', 'color':'lime'})
          element.parent().siblings('label.status').css('color', 'lime').html('<i class="ion-checkmark">&nbsp;&nbsp;'+ res.message +'</i>')
          $('input[type="submit"]').prop('disabled', false)
        } else {
          element.css({'border-color':'red', 'color':'red'})
          element.parent().siblings('label.status').css('color', 'red').html('<i class="ion-close">&nbsp;&nbsp;'+ res.message +'</i>')
          $('input[type="submit"]').prop('disabled', true)
        }
      })
      .fail(function(){
        toastr.error("Failed! Something went wrong")
      })
    })
  </script>
@endsection