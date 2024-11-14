<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    // Display a listing of the animals
    public function index()
    {
        $animals = Animal::latest()->paginate(16);
        return view('admin.animals.index', compact('animals'));
    }

    // Show the form for creating a new animal
    public function create()
    {
        return view('admin.animals.create');
    }

    // Store a newly created animal in storage
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (count($imagePaths) >= 5) break;
                $path = $image->store('animals_images', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

        Animal::create($validated);

        return redirect()->route('animals.index')->with('success', 'Животное успешно добавлено!');
    }



    // Display the specified animal
    public function show(Animal $animal)
    {
        return view('admin.animals.show', compact('animal'));
    }

    // Show the form for editing the specified animal
    public function edit(Animal $animal)
    {
        return view('admin.animals.edit', compact('animal'));
    }

    // Update the specified animal in storage
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);

        // Handle image uploads and update existing images
        $imagePaths = $animal->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (count($imagePaths) >= 5) break; // Limit to 5 images
                $path = $image->store('animals_images', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = array_slice($imagePaths, 0, 5);

        $animal->update($validated);

        return redirect()->route('animals.index')->with('success', 'Животное успешно добавлено!');
    }



    // Remove the specified animal from storage
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
        return redirect()->route('animals.index')->with('success', 'Animal deleted successfully.');
    }

    public function moveImageToFront(Request $request, Animal $animal)
{
    $validated = $request->validate([
        'image' => 'required|string',
    ]);

    $images = $animal->images ?? [];
    $imageToMove = $validated['image'];

    if (in_array($imageToMove, $images)) {
        // Remove the image from its current position
        $images = array_filter($images, fn($img) => $img !== $imageToMove);
        // Add the image to the beginning
        array_unshift($images, $imageToMove);
        $animal->update(['images' => $images]);
    }

    return redirect()->route('animals.edit', $animal->id)->with('success', 'Image moved to front successfully.');
}
}
