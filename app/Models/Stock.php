<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected $fillable = [
    	'quantity',
    	'unit',
    	'total_value',
        'verified',
    	'article_id'
    ];

    //belongs to Article Model

    public function article(){
    	return $this->belongsTo('App\Models\Article');
    }
}
