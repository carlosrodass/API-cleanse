<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    // public function index(){
        
    //     return Offer::class;
    // }

    public function index() 
    {
        $var = DB::table('offers')
        ->get();
        
        return $var;

    }
}
