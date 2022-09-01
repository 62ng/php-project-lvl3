<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    public function index(): View
    {
        $urls = DB::table('urls')
            ->orderBy('id')
            ->paginate();

        $urlIds = $urls->pluck('id');

        $lastChecks = DB::table('url_checks')
            ->select(['url_id', DB::raw('MAX(created_at) as check_date'), 'status_code'])
            ->whereIn('url_id', $urlIds)
            ->groupBy('url_id', 'status_code')
            ->get();

        $checksGrouped = $lastChecks->keyBy('url_id');

        $checks = $urlIds->flip()->map(function ($item, $key) use ($checksGrouped) {
            return $checksGrouped[$key] ?? null;
        });

        return view('urls.index', compact('urls', 'checks'));
    }

    public function create(): Response
    {
        //
    }

    public function store(Request $request): Response
    {
        //
    }

    public function show($id): View
    {
        $url = DB::table('urls')->find($id);

        if (!$url) {
            abort(404);
        }

        $checks = DB::table('url_checks')
            ->where('url_id', '=', $url->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('urls.show', compact('url', 'checks'));
    }

    public function edit($id): Response
    {
        //
    }

    public function update(Request $request, $id): Response
    {
        //
    }

    public function destroy($id): Response
    {
        //
    }
}
