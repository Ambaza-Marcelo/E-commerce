<?php

namespace App\Exports;

use App\Models\StockoutDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockoutExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StockoutDetail::all();
    }
}
