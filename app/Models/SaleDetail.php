<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    //
     protected $fillable = [
    	'date',
    	'article_id',
        'bon_no',
    	'quantity',
        'created_by',
        'customer',
    	'observation',
        'total_value',
        'commande_no',
    ];
    //belongs to article model
    public function article(){
    	return $this->belongsTo('App\Models\Article');
    }
}
