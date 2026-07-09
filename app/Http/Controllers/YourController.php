<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YourController extends Controller
{
    public function index()
    {
        // Logica del metodo index
        return view('yourview');
    }

    public function workWithUs()
    {
        // Logica del metodo workWithUs
        return view('workwithus'); // Assicurati che questa vista esista
    }
}
