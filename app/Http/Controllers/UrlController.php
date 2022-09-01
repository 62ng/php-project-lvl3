<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        $urlData = parse_url($request->input('url.name'));
        $urlNormalized = implode('', [$urlData['scheme'], '://', $urlData['host']]);

        $id = DB::table('urls')->insertGetId([
            'name' => $urlNormalized,
            'created_at' => now()
        ]);

        flash('URL успешно добавлен')
            ->success();

        return redirect()->route('urls.show', $id);
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
}
