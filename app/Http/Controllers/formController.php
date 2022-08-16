<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class formController extends Controller
{
    public function getForm(Request $request) {
        dump($request->all());
    }
}
