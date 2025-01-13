<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // Logic to fetch products and return the shop view
        return view('shop.index'); // Adjust this to your actual view
    }
}
