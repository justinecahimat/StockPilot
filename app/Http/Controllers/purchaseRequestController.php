<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class purchaseRequestController extends Controller
{
    public function index()
    {
        return view('purchase-request');
    }
}