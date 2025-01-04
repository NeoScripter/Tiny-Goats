<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Animal;
use App\Models\Household;
use App\Models\News;
use App\Models\Partner;
use App\Models\Specialist;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->query('query');

        if (empty($term)) {
            $paginatedResults = new LengthAwarePaginator([], 0, 20);
            return view('users.search', compact('paginatedResults', 'term'));
        }

        $animals = Animal::select('id', 'name', 'father_id', 'mother_id', 'isMale', 'birthDate')
            ->where('name', 'ILIKE', "%{$term}%")
            ->orWhere('breed', 'ILIKE', "%{$term}%")
            ->get();

        $households = Household::select('id', 'name', 'owner', 'region', 'country', 'address')
            ->where('name', 'ILIKE', "%{$term}%")
            ->orWhere('region', 'ILIKE', "%{$term}%")
            ->orWhere('owner', 'ILIKE', "%{$term}%")
            ->orWhere('breeds', 'ILIKE', "%{$term}%")
            ->get();

        $specialists = Specialist::select('id', 'name', 'speciality')
            ->where('name', 'ILIKE', "%{$term}%")
            ->orWhere('speciality', 'ILIKE', "%{$term}%")
            ->get();

        $news = News::select('id', 'title', 'content')
            ->where('title', 'ILIKE', "%{$term}%")
            ->orWhere('content', 'ILIKE', "%{$term}%")
            ->get();

        $partners = Partner::select('id', 'name', 'info')
            ->where('name', 'ILIKE', "%{$term}%")
            ->orWhere('info', 'ILIKE', "%{$term}%")
            ->get();


        $results = collect()
            ->merge($animals->map(fn($item) => ['type' => 'animal', 'data' => $item]))
            ->merge($households->map(fn($item) => ['type' => 'household', 'data' => $item]))
            ->merge($specialists->map(fn($item) => ['type' => 'specialist', 'data' => $item]))
            ->merge($news->map(fn($item) => ['type' => 'news', 'data' => $item]))
            ->merge($partners->map(fn($item) => ['type' => 'partner', 'data' => $item]));

        $perPage = 20;
        $currentPage = $request->input('page', 1);
        $paginatedResults = $this->paginateResults($results, $currentPage, $perPage);

        return view('users.search', compact('paginatedResults', 'term'));
    }

    private function paginateResults(Collection $items, $currentPage, $perPage)
    {
        $offset = ($currentPage - 1) * $perPage;
        $paginatedItems = $items->slice($offset, $perPage)->values();

        return new LengthAwarePaginator(
            $paginatedItems,
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
