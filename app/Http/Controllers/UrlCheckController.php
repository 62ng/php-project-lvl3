<?php

namespace App\Http\Controllers;

use DiDom\Document;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function store(int $id): RedirectResponse
    {
        $url = DB::table('urls')->find($id);
        abort_unless($url, 404);

        try {
            $response = Http::get($url->name);

            $document = new Document($response->body());

            $h1 = optional($document->first('h1'))->text();

            $title = optional($document->first('title'))->text();

            $description = optional($document->first('meta[name=description]'))->attr('content');

            DB::table('url_checks')->insert([
                'url_id' => $url->id,
                'status_code' => $response->status(),
                'h1' => $h1,
                'title' => $title,
                'description' => $description,
                'created_at' => now()
            ]);
        } catch (ConnectionException $e) {
            flash($e->getMessage())
                ->error();
        } finally {
            return redirect()->route('urls.show', $id);
        }
    }
}
