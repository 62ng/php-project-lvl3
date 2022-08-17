<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormController extends Controller
{
    public function form(): View
    {
        flash('Welcome!');

        return view('form');
    }

    public function getFormData(Request $request): RedirectResponse
    {
        $validated = $request->validate([
//            'url.name' => 'required|url|unique:urls,name|max:255'
            'url.name' => 'required'
        ]);

        flash('Welcome Aboard!');

//        dd($validated['url']['name']);
        return redirect()->route('form');
    }

    public function urls(): View
    {
        flash('Welcome!');

        return view('urls');
    }
}
