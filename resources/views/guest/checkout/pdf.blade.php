<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Missing Item Report</title>
    <script href="{{ asset('test-barcode/fpdf17/code128.php') }}"></script>
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
     	<h3 class="title">{{ ucfirst($covered) }} Missing Item Report <br> ({{ Session::has('store_name') ? Session::get('store_name') : Auth::user()->name }})</h3>
        <span>Date: {{ Carbon\Carbon::now()->format('F d, Y h:i:s A') }}</span><br>
        <span>Date Coverage: {{ $date_coverage }}</span><br>
        <span>Printed By: {{ Session::has('name') ? Session::get('name') : Auth::user()->name }}</span>
        <h5 class="grand-total">Grand Total: {{ number_format($total, 2) }}</h5>
        <table id="products_tbl" style="font-size: 12px">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Transaction No</th>
                    <th>Cashier Assigned</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $value)
                    <tr>
                        <td>{{ $loop->index+1 }}.</td>
                        <td>{{ Carbon\Carbon::parse($value->date)->format('F, d Y') }}</td>
                        <td>{{ $value->invoice_no }}</td>
                        <td>{{ $value->name ? $value->name : 'Not Available' }}</td>
                        <td>{{ $value->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>