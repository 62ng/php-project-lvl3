<?php

namespace App\Http\Controllers;

use DiDom\Document;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckController extends Controller
{
    public function store(int $id): RedirectResponse
    {
        $url = DB::table('urls')->find($id);

        try {
            $response = Http::get($url->name);
        } catch (ConnectionException $e) {
            flash($e->getMessage())
                ->error();

            return redirect()->route('urls.show', $id);
        }

        $document = new Document($response->body());

        $h1Content = optional($document->first('h1'))->text();

        $titleContent = optional($document->first('title'))->text();

        $descriptions = $document->xpath('/html/head/meta[@name="description"]/@content');
        $description = $descriptions ? $descriptions[0] : null;

        DB::table('url_checks')->insert([
            'url_id' => $url->id,
            'status_code' => $response->status(),
            'h1' => $h1Content,
            'title' => $titleContent,
            'description' => $description,
            'created_at' => now()
        ]);

        return redirect()->route('urls.show', $url->id);
    }
}
