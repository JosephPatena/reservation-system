<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\Reservation;
use App\Helpers\Helper;
use Carbon\Carbon;
use Session;

class ReportsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filtered = new Collection;

        if (Session::has('date_range')) {
            $range = explode("-", Session::get('date_range'));
            $from = Carbon::parse($range[0])->format('Y-m-d H:i:s');
            $to = Carbon::parse($range[1])->format('Y-m-d H:i:s');
            $reservations = Reservation::whereBetween('created_at', [$from, $to])->latest()->get();
        }
        else{
            $reservations = Reservation::latest()->get();
        }

        foreach($reservations as $item){
            $inc_pckgs = "";
            if ($item->packages->count()) {
                foreach($item->packages as $package){
                    $inc_pckgs .= $package->amenity->name." ".Helper::get_owner_currency()->currency->iso_code." ".($package->price / $package->qty)." x ".$package->qty."  ";
                }
            }else{
                $inc_pckgs = "No Package";
            }

            $row = ([
                        $item->invoice_no,
                        $item->room->name,
                        $item->room->accomodation->name,
                        Helper::get_owner_currency()->currency->iso_code." ".number_format($item->room->price, 2),
                        $item->arrival_date,
                        $item->departure_date,
                        $item->guest->name,
                        $inc_pckgs,
                        Helper::get_owner_currency()->currency->iso_code." ".number_format($item->total, 2),
                        $item->status->name,
                        $item->payment_method->name
                    ]);
            $filtered->push($row);
        }

        return $filtered;
    }

    public function headings(): array
    {
        return [
            'Invoice #',
            'Room',
            'Accomodation Type',
            'Price',
            'Arrival Date',
            'Departure Date',
            'Guest',
            'Total',
            'Status',
            'Payment Method',
        ];
    }
}
