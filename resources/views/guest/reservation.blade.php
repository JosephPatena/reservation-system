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

    .customize {
      padding-left: 100px; padding-right: 100px;
    }

    @media screen and (max-width: 768px) {
      .customize {
        padding-left: 15px; padding-right: 15px;
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
              <h1>Reservation</h1>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section" id="site-section">
      <div class="customize">
        <div class="row">
          <div class="col-md-12 table-responsive">
            <h2 class="mb-5">Booking History</h2>
            <table class="table table table-striped table-condensed table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Invoice</th>
                  <th>Room</th>
                  <th>Room Type</th>
                  <th>Price</th>
                  <th>Arrival Date</th>
                  <th>Departure Date</th>
                  <th>Length of Stay (day)</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Payment Method</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($reservations as $key => $reservation)
                    <tr>
                      <td>{{ $key+1 }}.</td>
                      <td>{{ $reservation->invoice_no }}</td>
                      <td>
                        <img class="open-url" data-url="{{ route('room_details', $reservation->room_id) }}" data-toggle="tooltip" title="View Reports" style="width: 25px; height: 25px; cursor: pointer;" src="{{ url('storage/image/' . $reservation->room->images->first()->hash_name) }}" alt="Room Image">&nbsp;&nbsp;<a href="{{ route('room_details', $reservation->room_id) }}"  data-toggle="tooltip" title="View Details">{{ $reservation->room->name }}</a>
                      </td>
                      <td>{{ $reservation->room->accomodation->name }}</td>
                      <td>{{ Helper::get_owner_currency()->currency->symbol . number_format($reservation->room->price, 2) }}</td>
                      <td>{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("F d, Y h:i A") }}</td>
                      <td>{{ \Carbon\Carbon::parse($reservation->departure_date)->format("F d, Y h:i A") }}</td>
                      <td>{{ $reservation->length_of_stay }}</td>
                      <td>{{ Helper::get_owner_currency()->currency->symbol . number_format($reservation->total, 2) }}</td>
                      <td>
                        @if($reservation->status_id == 1)
                          <span class="badge bg-aqua">{{ $reservation->status->name }}</span>
                        @elseif($reservation->status_id == 2)
                          <span class="badge bg-red">{{ $reservation->status->name }}</span>
                        @elseif($reservation->status_id == 3)
                          <span class="badge bg-green">{{ $reservation->status->name }}</span>
                        @else
                          <span class="badge bg-yellow">{{ $reservation->status->name }}</span>
                        @endif
                      </td>
                      <td>{{ $reservation->payment_method->name }}</td>
                      <td>
                        @if(!$reservation->request_cancellation)
                          <a style="cursor: pointer;" class="cancel" data-toggle="modal" data-target="#cancel-form" data-id="{{ encrypt($reservation->id) }}">Request Cancellation</a><br>
                        @endif
                        <a href="{{ route('transaction_invoice', encrypt($reservation->id)) }}">View Invoice</a>
                      </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
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
    
    <div class="modal fade" id="cancel-form">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Request Cancellation</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form action="{{ route('cancel') }}" method="post" class="cancellation">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="form-horizontal">
                
                <input type="hidden" name="id" class="id">
                <div class="form-group row">
                  <label for="inputCancellation" class="col-sm-4 control-label">Cancellation Reason <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <textarea  name="reason" type="text" class="form-control" id="inputCancellation" placeholder="Please tell us your reason" required="">{{ old('reason') }}</textarea>
                  </div>
                </div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-sm">Proceed</button>
            </div>
          </form>

          <form class="check" style="display: none;">
            <div class="modal-body">
              <div class="form-horizontal">

                <div class="form-group row">
                  <label for="inputPass" class="col-sm-4 control-label">Password <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <input  name="password" type="password" class="form-control" id="inputPass" placeholder="Please enter your password" required="">
                  </div>
                </div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-sm">Proceed</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('scripts')
  <script type="text/javascript">
    var pathname = window.location.pathname;
    var origin   = window.location.origin;
    window.location.href = origin + pathname + "#site-section"

    $(document).on('click', '.cancel', function(){
      $('input.id').val($(this).data('id'))
    })

    $(document).on('submit', 'form.cancellation', function(evt){
      evt.preventDefault()
      $(this).hide()
      $(this).siblings().show()
    })

    $(document).on('submit', 'form.check', function(evt){
      evt.preventDefault()
      let element = $(this)

      $.ajax({
        url: "{{ route('check_password') }}",
        data: $(this).serialize(),
        dataType: "json",
        type: "post"
      })
      .done(function(correct){
        if (correct) {
          console.log(element.siblings())
          element.siblings()[1].submit()
        }else{
          toastr.error("Password is incorrect")
        }
      })
      .fail(function(){
        toastr.error("Failed! Something went wrong")
      })
    })
  </script>
@endsection