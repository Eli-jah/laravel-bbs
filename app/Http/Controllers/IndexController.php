<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function test(Request $request){
        return Storage::disk('public')->download('img/Owl.jpg');
    }
}
