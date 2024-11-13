<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     */
    public function index()
    {
        $newsItems = News::latest()->paginate(16);
        return view('admin.news.index', compact('newsItems'));
    }

    /**
     * Show the form for creating a new news item.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news item in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle the image upload
        $imagePath = $request->file('image')?->store('news_images', 'public');

        // Create the news item
        News::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'categories' => $validatedData['categories'],
            'image' => $imagePath,
        ]);

        return redirect()->route('news.index')->with('success', 'Новость успешно создана!');
    }

    /**
     * Display the specified news item.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news item.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news item in storage.
     */
    public function update(Request $request, News $news)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Handle the image upload if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news_images', 'public');
        } else {
            $imagePath = $news->image;
        }

        // Update the news item
        $news->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'categories' => $validatedData['categories'],
            'image' => $imagePath,
        ]);

        return redirect()->route('news.index')->with('success', 'Новость успешно обновлена!');
    }

    /**
     * Remove the specified news item from storage.
     */
    public function destroy(News $news)
    {
        // Delete the associated image if it exists
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'Новость успешно удалена!');
    }
}
