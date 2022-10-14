<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [
    	'code',
    	'name',
        'quantity',
        'unit',
    	'unit_price',
        'expiration_date',
        'specification',
        'status',
        'created_by',
        'threshold_quantity',
    	'category_rayon_id'
    ];


     public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function stock(){
    	return $this->hasMany('App\Models\Stock','article_id');
    }

    public function stockinDetail(){
    	return $this->hasMany('App\Models\StockinDetail','article_id');
    }

    public function saleDetail(){
    	return $this->hasMany('App\Models\SaleDetail','article_id');
    }


    public function report(){
        return $this->hasMany('App\Models\Report','article_id');
    }
}
