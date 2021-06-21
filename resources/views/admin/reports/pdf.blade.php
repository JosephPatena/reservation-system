<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Reservation Reports</title>
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
     	<h3 class="title">Reservation Reports</h3>
        <span>Date: {{ Carbon\Carbon::now()->format('F d, Y h:i A') }}</span><br>
        <span>Date Coverage: {{ Session::has('date_range') ? Session::get('date_range') : "All" }}</span><br>
        <span>Printed By: {{ Auth::user()->name }}</span>
        <table id="products_tbl" style="font-size: 12px">
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
                    <th>Reserved By</th>
                    <th>Guest</th>
                    <th>Included Package</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $key => $reservation)
                    <tr>
                        <td>{{ $key+1 }}.</td>
                        <td>{{ $reservation->invoice_no }}</td>
                        <td>
                            {{ $reservation->room->name }}
                        </td>
                        <td>{{ $reservation->room->accomodation->name }}</td>
                        <td>{{ Helper::get_owner_currency()->currency->iso_code ." ". number_format($reservation->room->price, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->arrival_date)->format("F d, Y h:i A") }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->departure_date)->format("F d, Y h:i A") }}</td>
                        <td>{{ $reservation->length_of_stay }}</td>
                        <td>
                            {{ $reservation->guest->name }}
                        </td>
                        <td>
                            @php
                              $guests = explode(",", $reservation->guests);
                            @endphp

                            @foreach($guests as $guest)
                              {{ $guest }},<br>
                            @endforeach
                        </td>
                        <td>
                            @forelse($reservation->packages as $package)
                              {{ $package->amenity->name }}<br>
                              <small style="color: red;">
                                {{ Helper::get_owner_currency()->currency->iso_code ." ". ($package->price / $package->qty) }}&nbsp;x&nbsp;{{ $package->qty }}<br>
                              </small>
                            @empty
                              No Package
                            @endforelse
                        </td>
                        <td style="color: red">{{ Helper::get_owner_currency()->currency->iso_code ." ". number_format($reservation->total, 2) }}</td>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>