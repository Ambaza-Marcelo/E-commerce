<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
    	'supplier_id',
        'commande_no',
    	'purchase_bon_no',
        'start_date',
        'end_date',
        'description',
        'status'
    ];
    //belongs to supplier model
    public function supplier(){
    	return $this->belongsTo('App\Models\Supplier');
    }

}
