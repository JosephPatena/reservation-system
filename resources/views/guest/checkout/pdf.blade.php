<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice Details</title>
    <style type="text/css">
        #products_tbl {
            width: 100%;
        }

        table {
            border-collapse: collapse;
        }

        th {
            background: #ccc;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        tr:nth-child(even) {
            background: #efefef;
        }

        .title {
            text-align: center;
        }

        span {
            font-size: 12px;
            font-weight: bold;
        }

        .grand-total {
            margin-left: 530px; 
        }

    </style>
</head>

<body>
    <div class="invoice-box">
        <h3 class="title">Invoice Details</h3>
        <span>Invoice: #{{ $reservation->invoice_no }}</span><br>
        <span>Transaction Date: {{ \Carbon\Carbon::parse($reservation->created_at)->format("m/d/Y") }}</span><br>
        <span>Bill To: {{ $reservation->guest->name }}</span><br>
        <span>Phone: {{ $reservation->guest->phone }}</span><br>
        <span>Email: {{ $reservation->guest->email }}</span><br>
        <span>Payment method: {{ $reservation->payment_method->name }}</span><br>

        <table id="products_tbl" style="font-size: 12px">
            <thead>
                <tr>
                  <th>GUEST</th>
                  <th>ROOM TYPE</th>
                  <th>PRICE</th>
                  <th>ARRIVAL DATE</th>
                  <th>DEPARTURE DATE</th>
                  <th>LENGTH STAY (day)</th>
                  @if($reservation->packages->count())
                    <th>INCLUDED PACKAGE</th>
                  @endif
                  <th>SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
              <tr class="single-row">
                <td>
                  @php
                    $guests = explode(",", $reservation->guests);
                  @endphp

                  @foreach($guests as $guest)
                    {{ $guest }},<br>
                  @endforeach
                </td>
                <td>{{ $reservation->room->accomodation->name }}</td>
                <td>{{ Helper::get_owner_currency()->currency->iso_code . number_format($reservation->room->price, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("F d, Y h:i A") }}</td>
                <td>{{ \Carbon\Carbon::parse($reservation->departure_date)->format("F d, Y h:i A") }}</td>
                <td>{{ $reservation->length_of_stay }}</td>
                @if($reservation->packages->count())
                  <td>
                    @foreach($reservation->packages as $package)
                      {{ $package->amenity->name }}&nbsp;&nbsp;{{ Helper::get_owner_currency()->currency->iso_code . ($package->price / $package->qty) }}&nbsp;x&nbsp;{{ $package->qty }}<br>
                    @endforeach
                  </td>
                @endif
                <td>{{ Helper::get_owner_currency()->currency->iso_code . number_format($reservation->total, 2) }}</td>
              </tr>
              <tr>
                  <td colspan="6"></td>
                  <td>Total</td>
                  <td>{{ Helper::get_owner_currency()->currency->iso_code . number_format($reservation->total, 2) }}</td>
              </tr>
            </tbody>
        </table>
    </div>
</body>
</html>