<?php

namespace App\Exports;

use App\Models\MachineRepairingDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class MachineRepairingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MachineRepairingDetail::all();
    }
}
