<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArticleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
     public function headings():array{
        return[
            'Id',
            'Article Name',
            'Article Code',
            'Deposit',
            'Status',
            'Unit Price',
            'Created_at',
            'Updated_at' 
        ];
    } 
    public function collection()
    {
        return Article::all();
    }
}
