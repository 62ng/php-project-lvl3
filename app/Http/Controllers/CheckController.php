<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckController extends Controller
{
    public function store($id): RedirectResponse
    {
        $url = DB::table('urls')->find($id);

        try {
            $response = Http::get($url->name);
        } catch (ConnectionException $e) {
            flash($e->getMessage())
                ->error();

            return redirect()->route('urls.show', $id);
        }

        DB::table('url_checks')->insert([
            'url_id' => $url->id,
            'status_code' => $response->status(),
            'created_at' => now()
        ]);

        return redirect()->route('urls.show', $url->id);
    }
}
