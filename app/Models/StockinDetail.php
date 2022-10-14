<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockinDetail extends Model
{
    //
    protected $fillable = [
    	'article_id',
    	'date',
    	'unit',
        'invoice_no',
        'bon_no',
        'total_value',
        'handingover',
        'supplier',
        'commande_no',
        'reception_no',
    	'observation',
        'created_by',
        'origin'
    ];

    public function article(){
    	return $this->belongsTo('App\Models\Article');
    }
}
