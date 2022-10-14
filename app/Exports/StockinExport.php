<?php

namespace App\Exports;

use App\Models\StockinDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockinExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StockinDetail::all();
    }
}
