<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function index(): View
    {
        return view('urls.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
//        $validator = Validator::make($request->all(), [
//            'url.name' => 'required|url|unique:urls,name|max:255'
//        ]);
//
//        if ($validator->fails()) {
//            flash('Некорректный URL')
//                ->error();
//
//            return redirect()->route('form')
//                ->withInput();
//        }
//
//        $id = DB::table('urls')->insertGetId([
//            'name' => $request->input('url.name')
//        ]);
//
//        return redirect()->route('urls.show', $id);
    }

    public function show($id): View
    {
        $url = DB::table('urls')->find($id);

        if (!$url) {
            abort(404);
        }

        return view('urls.show', compact('url'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
