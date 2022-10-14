<?php

namespace App\Exports;

use App\Models\ReceptionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReceptionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReceptionDetail::all();
    }
}
