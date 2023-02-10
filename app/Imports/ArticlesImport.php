<?php

namespace App\Imports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArticlesImport implements ToModel
{
    /**
    * @param array $row 
    *import xls file of items
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    //import items
    public function model(array $row)
    {
        return new Article([
        'code' => $row['code'],
        'name' => $row['name'],
        'unit' => $row['unit'],
        'unit_price' => $row['unit_price'],
        'status' => $row['status'],
        'created_by' => $row['created_by'],
        'deposit_category_rayon_id' => $row['deposit_category_rayon_id']
        ]);
    }
}
