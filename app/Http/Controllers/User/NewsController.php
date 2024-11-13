<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $allowedCategories = ['Новости', 'Статьи', 'События'];

    public function index($category = null)
    {
        if ($category && !in_array($category, $this->allowedCategories)) {
            abort(404, 'Category not found');
        }

        $news = News::latest();

        if ($category) {
            $news = $news->whereJsonContains('categories', $category);
        }

        $news = $news->paginate(16);

        return view('users.news', compact('news'));
    }
}
