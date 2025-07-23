<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Faqs;
use App\Models\Pages;
use App\Models\Products;
use App\Models\SearchLog;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json(['message' => 'Query parameter q is required'], 400);
        }

        SearchLog::create([
            'term' => $query,
            'user_id' => 1,
           
        ]);
        // //'user_id' => auth()->id(),
        // Merge results from all searchable models
        $results = collect()
            ->merge(Blog::search($query)->get())
            ->merge(Products::search($query)->get())
            ->merge(Pages::search($query)->get())
            ->merge(Faqs::search($query)->get())
            ->map(function ($item) {
                $type = method_exists($item, 'raw') ? ($item->raw()['type'] ?? class_basename($item)) : class_basename($item);
                $link = method_exists($item, 'raw') ? ($item->raw()['link'] ?? url("/{$type}/{$item->id}")) : url("/{$type}/{$item->id}");

                return [
                    'type' => $type,
                    'title' => $item->title ?? $item->name ?? $item->question,
                    'snippet' => Str::limit(
                        $item->body ?? $item->description ?? $item->content ?? $item->answer,
                        150
                    ),
                    'link' => $link,
                    'updated_at' => $item->updated_at ?? now(),
                ];
            })
            ->sortByDesc('updated_at');
        // Pagination
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $paginated = new LengthAwarePaginator(
            $results->forPage($page, $perPage)->values(),
            $results->count(),
            $perPage,
            $page
        );

        return response()->json($paginated);
    }


    public function logs()
    {
        
        $topTerms = DB::table('search_logs')
            ->select('term', DB::raw('count(*) as count'))
            ->groupBy('term')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return response()->json($topTerms);
    }
}
