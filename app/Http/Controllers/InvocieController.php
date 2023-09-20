<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvocieController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }   
}
