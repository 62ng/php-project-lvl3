<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckController extends Controller
{
    public function store($id): RedirectResponse
    {
        DB::table('url_checks')->insert([
            'url_id' => $id,
            'status_code' => null,
            'created_at' => now()
        ]);

        return redirect()->route('urls.show', $id);
    }
}
