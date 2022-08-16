<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class formController extends Controller
{
    public function getFormData(Request $request) {
        $validated = $request->validate([
//            'url.name' => 'required|url|unique:urls,name|max:255'
            'url.name' => 'required'
        ]);

        dd($validated['url']['name']);
    }
}
