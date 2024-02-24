<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function example()
    {
        return response()->json(['message' => 'Hello from Laravel API']);
    }
}
