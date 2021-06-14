@extends('layout.guest')

@section('stylesheets')
  <style type="text/css">
      /* Variables */

      #payment-form {
        width: 100%;
        align-self: center;
        box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1), 0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
        padding: 40px;
      }

      input {
        border-radius: 6px;
        margin-bottom: 6px;
        padding: 12px;
        border: 1px solid rgba(50, 50, 93, 0.1);
        height: 44px;
        font-size: 16px;
        width: 100%;
        background: white;
      }

      .result-message {
        line-height: 22px;
        font-size: 16px;
      }

      .result-message a {
        color: rgb(89, 111, 214);
        font-weight: 600;
        text-decoration: none;
      }

      .hidden {
        display: none;
      }

      #card-error {
        color: rgb(105, 115, 134);
        text-align: left;
        font-size: 13px;
        line-height: 17px;
        margin-top: 12px;
      }

      #card-element {
        border-radius: 4px 4px 0 0 ;
        padding: 12px;
        border: 1px solid rgba(50, 50, 93, 0.1);
        height: 44px;
        width: 100%;
        background: white;
      }

      #payment-request-button {
        margin-bottom: 32px;
      }

      /* Buttons and links */
      #submit {
        background: #5469d4;
        color: #ffffff;
        font-family: Arial, sans-serif;
        border-radius: 0 0 4px 4px;
        border: 0;
        padding: 12px 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        display: block;
        transition: all 0.2s ease;
        box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
        width: 100%;
      }
      #submit:hover {
        filter: contrast(115%);
      }
      #submit:disabled {
        opacity: 0.5;
        cursor: default;
      }

      /* spinner/processing state, errors */
      .spinner,
      .spinner:before,
      .spinner:after {
        border-radius: 50%;
      }
      .spinner {
        color: #ffffff;
        font-size: 22px;
        text-indent: -99999px;
        margin: 0px auto;
        position: relative;
        width: 20px;
        height: 20px;
        box-shadow: inset 0 0 0 2px;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
      }
      .spinner:before,
      .spinner:after {
        position: absolute;
        content: "";
      }
      .spinner:before {
        width: 10.4px;
        height: 20.4px;
        background: #5469d4;
        border-radius: 20.4px 0 0 20.4px;
        top: -0.2px;
        left: -0.2px;
        -webkit-transform-origin: 10.4px 10.2px;
        transform-origin: 10.4px 10.2px;
        -webkit-animation: loading 2s infinite ease 1.5s;
        animation: loading 2s infinite ease 1.5s;
      }
      .spinner:after {
        width: 10.4px;
        height: 10.2px;
        background: #5469d4;
        border-radius: 0 10.2px 10.2px 0;
        top: -0.1px;
        left: 10.2px;
        -webkit-transform-origin: 0px 10.2px;
        transform-origin: 0px 10.2px;
        -webkit-animation: loading 2s infinite ease;
        animation: loading 2s infinite ease;
      }

      @-webkit-keyframes loading {
        0% {
          -webkit-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @keyframes loading {
        0% {
          -webkit-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
  </style>
@endsection

@section('content')
  
  <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url('{{ Helper::get_contents()[0]->default ? asset('guest/images/big_image_1.jpg') : url('storage/image/' . Helper::get_contents()[0]->image->hash_name) }}');">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Payment Details</h1>
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
                        <td>{{ $room->max_guest }}</td>
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
                  <form id="payment-form">
                    <div id="card-element"><!--Stripe.js injects the Card Element--></div>
                    <button id="submit">
                      <div class="spinner hidden" id="spinner"></div>
                      <span id="button-text">Pay now</span>
                    </button>
                    <p id="card-error" role="alert"></p>
                    <p class="result-message hidden">
                      Payment succeeded, see the result in your
                      <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
                    </p>
                  </form>
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
                      <li style="cursor: pointer;" data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ $key==0 ? "active" : "" }}"></li>
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
  <script src="https://js.stripe.com/v3/"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
  <script type="text/javascript">
    var pathname = window.location.pathname;
    var origin   = window.location.origin;
    window.location.href = origin + pathname + "#site-section"
    // A reference to Stripe.js initialized with your real test publishable API key.
    var stripe = Stripe("{{ $payment_method->public_key }}");

    // Disable the button until we have Stripe set up on the page
    document.querySelector("button").disabled = true;
    fetch("{{ route('stripe.create_order') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        'X-CSRF-TOKEN': "{{ csrf_token() }}",
      },
    })
    .then(function(result) {
      return result.json();
    })
    .then(function(data) {
      var elements = stripe.elements();

      var style = {
        base: {
          color: "#32325d",
          fontFamily: 'Arial, sans-serif',
          fontSmoothing: "antialiased",
          fontSize: "16px",
          "::placeholder": {
            color: "#32325d"
          }
        },
        invalid: {
          fontFamily: 'Arial, sans-serif',
          color: "#fa755a",
          iconColor: "#fa755a"
        }
      };

      var card = elements.create("card", { style: style });
      // Stripe injects an iframe into the DOM
      card.mount("#card-element");

      card.on("change", function (event) {
        // Disable the Pay button if there are no card details in the Element
        document.querySelector("button").disabled = event.empty;
        document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
      });

      var form = document.getElementById("payment-form");
      form.addEventListener("submit", function(event) {
        event.preventDefault();
        // Complete payment when the submit button is clicked
        payWithCard(stripe, card, data.clientSecret);
      });
    });

    // Calls stripe.confirmCardPayment
    // If the card requires authentication Stripe shows a pop-up modal to
    // prompt the user to enter authentication details without leaving your page.
    var payWithCard = function(stripe, card, clientSecret) {
      loading(true);
      stripe
        .confirmCardPayment(clientSecret, {
          payment_method: {
            card: card
          }
        })
        .then(function(result) {
          if (result.error) {
            // Show error to your customer
            showError(result.error.message);
          } else {
            // The payment succeeded!
            window.open("{{ route('setup_completion') }}", "_self")
          }
        });
    };

    // Show the customer the error from Stripe if their card fails to charge
    var showError = function(errorMsgText) {
      loading(false);
      var errorMsg = document.querySelector("#card-error");
      errorMsg.textContent = errorMsgText;
      setTimeout(function() {
        errorMsg.textContent = "";
      }, 4000);
    };

    // Show a spinner on payment submission
    var loading = function(isLoading) {
      if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("button").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
      } else {
        document.querySelector("button").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
      }
    };
  </script>
@endsection