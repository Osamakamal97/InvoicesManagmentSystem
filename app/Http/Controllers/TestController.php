<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Token\Stack;

class TestController extends Controller
{
    public function index()
    {
        return view('test', compact('text'));
    }
}
