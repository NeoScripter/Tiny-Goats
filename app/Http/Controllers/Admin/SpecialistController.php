<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecialistController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name');
        $char = $request->query('char');

        $specialists = Specialist::when($name, fn($query) => $query->where('name', 'like', "%$name%"))
            ->when($char, fn($query) => $query->where('name', 'like', "$char%"))
            ->latest()
            ->paginate(20)
            ->appends($request->query());

        return view('admin.specialists.index', compact('specialists'));
    }

    public function create()
    {
        return view('admin.specialists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'speciality' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'extraInfo' => 'nullable|string|max:1500',
            'contacts' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);

        $imagePath = $request->file('image')?->store('specialists', 'public');


        Specialist::create([
            'name' => $validated['name'],
            'speciality' => $validated['speciality'] ?? null,
            'education' => $validated['education'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'extraInfo' => $validated['extraInfo'] ?? null,
            'contacts' => $validated['contacts'] ?? null,
            'website' => $validated['website'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('specialists.index')->with('success', 'Специалист успешно создан!');
    }


    public function show(Specialist $specialist)
    {

        return view('admin.specialists.show', compact('specialist'));
    }


    public function edit(Specialist $specialist)
    {

        return view('admin.specialists.edit', compact('specialist'));
    }

    public function update(Request $request, Specialist $specialist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'speciality' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'extraInfo' => 'nullable|string|max:1500',
            'contacts' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);


        if ($request->hasFile('image')) {
            if ($specialist->image_path) {
                Storage::disk('public')->delete($specialist->image_path);
            }
            $imagePath = $request->file('image')->store('specialist', 'public');
        } else {
            $imagePath = $specialist->image_path;
        }


        $specialist->update([
            'name' => $validated['name'],
            'speciality' => $validated['speciality'] ?? null,
            'education' => $validated['education'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'extraInfo' => $validated['extraInfo'] ?? null,
            'contacts' => $validated['contacts'] ?? null,
            'website' => $validated['website'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('specialists.index')->with('success', 'Специалист успешно обновлен!');
    }


    public function destroy(Specialist $specialist)
    {
        if ($specialist->image_path) {
            Storage::disk('public')->delete($specialist->image_path);
        }

        $specialist->delete();
        return redirect()->route('specialists.index')->with('success', 'Специалист успешно удален!');
    }
}
