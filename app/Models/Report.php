<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable = [
    		'article_id',
    		'quantity_stock_initial',
    		'value_stock_initial',
    		'quantity_stockin',
    		'value_stockin',
    		'stock_total',
    		'quantity_stockout',
    		'value_stockout',
    		'quantity_stock_final',
    		'value_stock_final'
    ];

    public function article(){
    	return $this->belongsTo('App\Models\Article');
    }
}
