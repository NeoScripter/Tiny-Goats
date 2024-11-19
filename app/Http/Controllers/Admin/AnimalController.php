<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    public function index($category = null)
    {
        $query = Animal::latest();

        if ($category && $category === 'forSale') {
            $query->where('forSale', true);
        }

        $animals = $query->paginate(16);

        return view('admin.animals.index', compact('animals'));
    }

    public function create()
    {
        $maleAnimals = Animal::where('isMale', true)->get();
        $femaleAnimals = Animal::where('isMale', false)->get();
        $allAnimals = Animal::all();
        return view('admin.animals.create', compact('maleAnimals', 'femaleAnimals', 'allAnimals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'isMale' => 'required|boolean',
            'breed' => 'nullable|string|max:100',
            'forSale' => 'nullable|boolean',
            'color' => 'nullable|string|max:50',
            'eyeColor' => 'nullable|string|max:50',
            'birthDate' => 'nullable|date',
            'direction' => 'nullable|string|max:100',
            'siblings' => 'nullable|integer|min:0',
            'hornedness' => 'nullable|string|max:100',
            'birthCountry' => 'nullable|string|max:100',
            'residenceCountry' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:100',
            'labelNumber' => 'nullable|string|max:50|unique:animals,labelNumber',
            'height' => 'nullable|string|max:50',
            'rudiment' => 'nullable|string|max:100',
            'extraInfo' => 'nullable|string',
            'certificates' => 'nullable|string',
            'showOnMain' => 'nullable|boolean',
            'mother_id' => 'nullable|exists:animals,id',
            'father_id' => 'nullable|exists:animals,id',
            'children' => 'nullable|array',
            'children.*' => 'exists:animals,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (count($imagePaths) >= 4) break;
                $path = $image->store('animals_images', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

        $animal = Animal::create($validated);

        if ($request->has('children') && is_array($validated['children'])) {
            foreach ($validated['children'] as $childId) {
                $child = Animal::find($childId);
                if ($child) {
                    if ($animal->isMale) {
                        $child->father_id = $animal->id;
                    } else {
                        $child->mother_id = $animal->id;
                    }
                    $child->save();
                }
            }
        }

        return redirect()->route('animals.index')->with('success', 'Животное успешно добавлено!');
    }


    public function show(Animal $animal, $gens = 3)
    {
        if ($gens < 2 || $gens > 7 || !is_int($gens)) {
            $gens = 3;
        }

        $mother = Animal::find($animal->mother_id);
        $father = Animal::find($animal->father_id);
        return view('admin.animals.show', compact('animal', 'gens', 'mother', 'father'));
    }

    public function edit(Animal $animal)
    {
        $maleAnimals = Animal::where('isMale', true)->get();
        $femaleAnimals = Animal::where('isMale', false)->get();
        $allAnimals = Animal::all();
        return view('admin.animals.edit', compact('animal', 'maleAnimals', 'femaleAnimals', 'allAnimals'));
    }

    public function update(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'isMale' => 'required|boolean',
            'breed' => 'nullable|string|max:100',
            'forSale' => 'nullable|boolean',
            'color' => 'nullable|string|max:50',
            'eyeColor' => 'nullable|string|max:50',
            'birthDate' => 'nullable|date',
            'direction' => 'nullable|string|max:100',
            'siblings' => 'nullable|integer|min:0',
            'hornedness' => 'nullable|string|max:100',
            'birthCountry' => 'nullable|string|max:100',
            'residenceCountry' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:100',
            'labelNumber' => 'nullable|string|max:50|unique:animals,labelNumber,' . $animal->id,
            'height' => 'nullable|string|max:50',
            'rudiment' => 'nullable|string|max:100',
            'extraInfo' => 'nullable|string',
            'certificates' => 'nullable|string',
            'showOnMain' => 'nullable|boolean',
            'mother_id' => 'nullable|exists:animals,id',
            'father_id' => 'nullable|exists:animals,id',
            'children' => 'nullable|array',
            'children.*' => 'exists:animals,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);

        $validated['forSale'] = $request->has('forSale');
        $validated['showOnMain'] = $request->has('showOnMain');

        $sortedImages = json_decode($request->input('sortedImages'), true);

        if ($request->hasFile('images')) {
            $newImages = [];
            foreach ($request->file('images') as $index => $image) {
                if ($index >= 4) break;
                $path = $image->store('animals_images', 'public');
                $newImages[] = $path;
            }
            $validated['images'] = $newImages;
        } else {
            $validated['images'] = $sortedImages;
        }

        $animal->update($validated);

        if (isset($validated['children'])) {
            $newChildrenIds = $validated['children'];

            $currentChildren = $animal->isMale
                ? Animal::where('father_id', $animal->id)->get()
                : Animal::where('mother_id', $animal->id)->get();

            foreach ($currentChildren as $child) {
                if (!in_array($child->id, $newChildrenIds)) {
                    if ($animal->isMale) {
                        $child->father_id = null;
                    } else {
                        $child->mother_id = null;
                    }
                    $child->save();
                }
            }

            foreach ($newChildrenIds as $childId) {
                $child = Animal::find($childId);
                if ($child) {
                    if ($animal->isMale) {
                        $child->father_id = $animal->id;
                    } else {
                        $child->mother_id = $animal->id;
                    }
                    $child->save();
                }
            }
        }


        return redirect()->route('animals.index')->with('success', 'Животное успешно обновлено!');
    }


    public function destroy(Animal $animal)
    {
        if ($animal->images && is_array($animal->images)) {
            foreach ($animal->images as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        $animal->delete();
        return redirect()->route('animals.index')->with('success', 'Животное успешно удалено!');
    }

    public function moveImageToFront(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'image' => 'required|string',
        ]);

        $images = $animal->images ?? [];
        $imageToMove = $validated['image'];

        if (in_array($imageToMove, $images)) {
            $images = array_filter($images, fn($img) => $img !== $imageToMove);
            array_unshift($images, $imageToMove);
            $animal->update(['images' => $images]);
        }

        return redirect()->route('animals.edit', $animal->id)->with('success', 'Image moved to front successfully.');
    }
}
