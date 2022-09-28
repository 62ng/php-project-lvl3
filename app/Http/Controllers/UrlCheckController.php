<?php

namespace App\Http\Controllers;

use DiDom\Document;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UrlCheckController extends Controller
{
    public function store(int $id): RedirectResponse
    {
        $url = DB::table('urls')->find($id);
        abort_unless($url, 404);

        try {
            $response = Http::get($url->name);

            $document = new Document($response->body());

            $title = optional($document->first('title'))->text();

            $h1 = optional($document->first('h1'))->text();

            $description = optional($document->first('meta[name=description]'))->attr('content');

            DB::table('url_checks')->insert([
                'url_id' => $url->id,
                'status_code' => $response->status(),
                'h1' => $h1 ? Str::of($h1)->limit(255) : null,
                'title' => $title ? Str::of($title)->limit(255) : null,
                'description' => $description,
                'created_at' => now()
            ]);
        } catch (\Exception $e) {
            flash($e->getMessage())
                ->error();
        }

        return redirect()->route('urls.show', $id);
    }
}
