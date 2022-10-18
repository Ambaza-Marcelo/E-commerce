<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
class WelcomeController extends Controller
{
    //
    public function listProduct(){
    	$products = Article::all();

    	return view('welcome',compact('products'));
    }
    //buy item
    public function buy($id){
    	$article = Article::where('id',$id)->first();
    	return view('buy',compact('article'));
    }
}
