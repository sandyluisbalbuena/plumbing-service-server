<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request){


        return response()->json('wew');
    }
}
