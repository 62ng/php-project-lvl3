<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class FormController extends Controller
{
    public function form(Request $request): View
    {
        return view('form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'url.name' => 'required|url|unique:urls,name|max:255'
        ]);

        if ($validator->fails()) {
            flash('Некорректный URL')
                ->error();

            return redirect()->route('form')
                ->withInput();
        }

        return redirect()->route('form');
    }

    public function urls(): View
    {
        return view('urls');
    }
}
