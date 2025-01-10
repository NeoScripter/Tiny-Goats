<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()
            ->paginate(6);

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'conditions' => 'nullable|string|max:255',
            'info' => 'nullable|string|max:1500',
            'contacts' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);

        $imagePath = $request->file('image')
        ? $request->file('image')->store('partners', 'public')
        : null;


        Partner::create([
            'name' => $validated['name'],
            'conditions' => $validated['conditions'] ?? null,
            'info' => $validated['info'] ?? null,
            'contacts' => $validated['contacts'] ?? null,
            'website' => $validated['website'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('partners.index')->with('success', 'Партнер успешно создан!');
    }


    public function show(Partner $partner)
    {

        return view('admin.partners.show', compact('partner'));
    }


    public function edit(Partner $partner)
    {

        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'conditions' => 'nullable|string|max:255',
            'info' => 'nullable|string|max:1500',
            'contacts' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);


        if ($request->hasFile('image')) {
            if ($partner->image) {
                Storage::disk('public')->delete($partner->image);
            }
            $imagePath = $request->file('image')->store('partners', 'public');
        } else {
            $imagePath = $partner->image;
        }


        $partner->update([
            'name' => $validated['name'],
            'conditions' => $validated['conditions'] ?? null,
            'info' => $validated['info'] ?? null,
            'contacts' => $validated['contacts'] ?? null,
            'website' => $validated['website'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('partners.index')->with('success', 'Партнер успешно обновлен!');
    }


    public function destroy(Partner $partner)
    {
        if ($partner->image) {

            if (Storage::disk('public')->exists($partner->image)) {
                Storage::disk('public')->delete($partner->image);
            }
        }

        $partner->delete();
        return redirect()->route('partners.index')->with('success', 'Партнер успешно удален!');
    }
}
