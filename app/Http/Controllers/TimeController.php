<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeController extends Controller
{
    public function  index(){
        $time = Carbon::now();
        return response()->json(compact('time'));
    }

    public function  show($name){
        $time = Carbon::now();
        return response()->json(compact('time'));
    }
}
