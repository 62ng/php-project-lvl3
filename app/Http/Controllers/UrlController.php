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
        $urls = DB::table('urls')->get();

        $lastUrlChecks = DB::table('url_checks')
            ->select(['url_id', DB::raw('MAX(created_at) as check_date'), 'status_code'])
            ->groupBy('url_id', 'status_code')
            ->get();
        $urlChecks = $lastUrlChecks->keyBy('url_id');

        $groupedUrls = $urls->map(function ($item) use ($urlChecks) {
            $item->check_date = $urlChecks[$item->id]->check_date ?? null;
            $item->status_code = $urlChecks[$item->id]->status_code ?? null;

            return $item;
        });

        return view('urls.index', compact('groupedUrls'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
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
