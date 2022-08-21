<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckController extends Controller
{
    public function store($id): RedirectResponse
    {
        $url = DB::table('urls')->find($id);
        DB::table('url_checks')->insertGetId([
            'name' => $url['id']
        ]);

        return redirect()->route('urls.show', $url['id']);
    }
}
