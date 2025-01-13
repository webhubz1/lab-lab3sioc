<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //mao ni gi dagdag
    public function index()
    {
        return view('home'); // This returns the 'home' view
    }
}
