<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
     protected $fillable = [
    	'date',
        'bon_no',
    	'observation',
        'created_by',
        'customer',
        'commande_no'
    ];

}
