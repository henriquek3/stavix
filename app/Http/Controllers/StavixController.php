<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StavixController extends Controller
{
    public function index()
    {
        return view('ipfilter');
    }

    public function store(Request $request)
    {
        return response()->json(
            $request->all()
        );
    }
}
