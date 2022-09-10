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

        try {
            $response = Http::get($url->name);

            $document = new Document($response->body());

            $h1Content = optional($document->first('h1'))->text();

            $titleContent = optional($document->first('title'))->text();

            $descriptionContent = optional($document->first('meta[name=description]'))->attr('content');

            DB::table('url_checks')->insert([
                'url_id' => $url->id,
                'status_code' => $response->status(),
                'h1' => $h1Content,
                'title' => $titleContent,
                'description' => $descriptionContent,
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
