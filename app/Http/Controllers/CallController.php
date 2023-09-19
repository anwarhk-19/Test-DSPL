<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CallController extends Controller
{
    public function makeCall(Request $request)
    {
        return response()->json(['status' => 'Calling...']);
    }
}
