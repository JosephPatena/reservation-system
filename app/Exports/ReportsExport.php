<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\Reservation;

class ReportsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filtered = new Collection;
        Reservation::each(function($item) use ($filtered){
            $row = ([
                        $item->invoice_no,
                        $item->room->name,
                        $item->room->accomodation->name,
                        number_format($item->room->price, 2),
                        $item->arrival_date,
                        $item->departure_date,
                        $item->guest->name,
                        number_format($item->total, 2),
                        $item->status->name,
                        $item->payment_method->name
                    ]);
            $filtered->push($row);
        });

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
