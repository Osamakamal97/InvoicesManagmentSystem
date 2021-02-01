<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // Add by dashboard template
        if (view()->exists($id)) {
            return view($id);
        } else {
            return view('404');
        }
    }
}
