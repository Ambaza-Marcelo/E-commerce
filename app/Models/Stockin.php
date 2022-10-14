<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stockin extends Model
{
    //
    protected $fillable = [
    	'date',
    	'observation',
        'invoice_no',
        'bon_no',
        'created_by',
        'handingover',
        'commande_no',
        'reception_no',
        'origin',
        'country'
    ];

}
