<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable=[
    	'name',
    	'mail',
    	'phone_no',
    	'address_id'
    ];

    public function address(){
    	return $this->belongsTo('App\Models\Address');
    }

}
