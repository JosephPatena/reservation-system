@extends('layout.guest')

@section('stylesheets')
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400&display=swap" rel="stylesheet">
  <style type="text/css">

    .invoice-container {
      font-family: roboto;
      background: white;
    }

    .material-icons {
      cursor: pointer;
    }

    .invoice-container {
      margin: auto;
      padding: 0px 20px;
    }

    .invoice-header {
      display: flex;
      padding: 70px 0%;
      width: 100%;
    }

    .title {
      font-family: roboto;
      font-size: 18px;
      letter-spacing: 3px;
      color: rgb(66, 66, 66);
    }

    .date {
      padding: 5px 0px;
      font-size: 14px;
      letter-spacing: 3px;
      color: rgb(156, 156, 156);
    }

    .invoice-number {
      font-size: 17px;
      letter-spacing: 2px;
      color: rgb(156, 156, 156);
    }

    .space {
      width: 50%;
    }

    table {
      table-layout: auto;
      width: 100%;
    }
    table,
    th,
    td {
      border-collapse: collapse;
    }

    th {
      padding: 10px 0px;
      border-bottom: 1px solid rgb(187, 187, 187);
      border-bottom-style: dashed;
      font-weight: 400;
      font-size: 13px;
      letter-spacing: 2px;
      color: gray;
      text-align: left;
    }

    td {
      padding: 10px 0px;
      border-bottom: 0.5px solid rgb(226, 226, 226);
      text-align: left;
    }

    .dashed {
      border-bottom: 1px solid rgb(187, 187, 187);
      border-bottom-style: dashed;
    }

    .total {
      font-weight: 800;
      font-size: 20px !important;
      color: black;
    }


    #sum input[type="text"] {
      max-width: 170px;
      text-align: left;
      font-size: 15px;
      padding: 10px;
      border: none;
      outline: none;
    }

    #sum input[type="text"]:focus {
      border-radius: 5px;
      background: #ffffff;
      box-shadow: 11px 11px 22px #d9d9d9, -11px -11px 22px #ffffff;
    }

    /*Hide Arrows From Input Number*/
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }


    .float {
      width: 40px;
      height: 40px;
      background-color: #ff1d89;
      color: #fff;
      border-radius: 100%;
      text-align: center;
      box-shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.048),
        0 6.7px 5.3px rgba(0, 0, 0, 0.069), 0 12.5px 10px rgba(0, 0, 0, 0.085),
        0 22.3px 17.9px rgba(0, 0, 0, 0.101), 0 41.8px 33.4px rgba(0, 0, 0, 0.122),
        0 100px 80px rgba(0, 0, 0, 0.17);
    }

    .float:hover {
      background-color: #ff057e;
    }

    .plus {
      margin-top: 10px;
    }

    #sum {
      text-align: right;
      width: 100%;
    }

    #sum input[type="text"] {
      width: 100%;
      font-size: 33px !important;
      color: black;
      text-align: right !important;
    }

    /* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {
      body {
        background: lemonchiffon;
      }
      .invoice-container {
        border: solid 1px gray;
        width: 60%;
        margin: 50px auto;
        padding: 40px;
        padding-bottom: 100px;
        border-radius: 5px;
        background: white;
        box-shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.02),
          0 6.7px 5.3px rgba(0, 0, 0, 0.028), 0 12.5px 10px rgba(0, 0, 0, 0.035),
          0 22.3px 17.9px rgba(0, 0, 0, 0.042), 0 41.8px 33.4px rgba(0, 0, 0, 0.05),
          0 100px 80px rgba(0, 0, 0, 0.07);
      }

      .title-date {
        width: 20%;
      }
      .invoice-number {
        width: 20%;
      }
      .space {
        width: 80%;
      }
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
      <div class="row">
        <div class="col-md-12">
          <div class="invoice-container">
            <i class="ion-ios-printer-outline open-url" data-url="{{ route('print_invoice', encrypt($reservation->id)) }}" style="cursor: pointer;">&nbsp;&nbsp;Print</i>
            <div class="invoice-header">
              <div class="title-date">
                <h2 class="title">INVOICE</h2>
                <p class="date">{{ \Carbon\Carbon::parse($reservation->created_at)->format("m/d/Y") }}</p>
                <h2 class="title">BILL TO</h2>
                <p class="date" style="width: 700px">Name: {{ $reservation->guest->name }} <br> Phone: {{ $reservation->guest->phone }} <br> Email: {{ $reservation->guest->email }}<br> Payment method: {{ $reservation->payment_method->name }}</p>
              </div>
              <div class="space"></div>
              <p class="invoice-number">#{{ $reservation->invoice_no }}</p>
            </div>
            <div class="invoice-body">
              <table>
                <thead>
                  <th>ROOM TYPE</th>
                  <th>PRICE</th>
                  <th>ARRIVAL DATE</th>
                  <th>DEPARTURE DATE</th>
                  <th>LENGTH OF STAY (DAY)</th>
                  <th>SUBTOTAL</th>
                </thead>

                <tbody id="table-body">
                  <tr class="single-row">
                    <td>{{ $reservation->room->accomodation->name }}</td>
                    <td>{{ Helper::get_owner_currency()->currency->symbol . number_format($reservation->room->price, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("F d, Y h:i A") }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservation->departure_date)->format("F d, Y h:i A") }}</td>
                    <td>{{ $reservation->length_of_stay }}</td>
                    <td>{{ Helper::get_owner_currency()->currency->symbol . number_format($reservation->total, 2) }}</td>
                  </tr>
                </tbody>
              </table>
              <div id="sum"><input type="text" placeholder="{{ Helper::get_owner_currency()->currency->symbol . number_format($reservation->total, 2) }}" name="total" class="total" id="total" disabled></div>

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
