<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $gender = $request->query('gender');
        $breed = $request->query('breed');
        $name = $request->query('name');
        $char = $request->query('char');

        $animals = Animal::with(['father', 'mother'])
            ->when($gender, fn($query) => $query->where('isMale', $gender === 'male'))
            ->when($breed, fn($query) => $query->where('breed', $breed))
            ->when($name, fn($query) => $query->where('name', 'like', "%$name%"))
            ->when($char, fn($query) => $query->where('name', 'like', "$char%"))
            ->latest()
            ->paginate(20)
            ->appends($request->query());

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


    public function show(Animal $animal, Request $request)
    {
        $gens = $request->query('gens', 3);
        $photo = $request->query('photo', true);

        $gens = is_numeric($gens) && $gens >= 1 && $gens <= 7 ? (int) $gens : 3;

        $photo = filter_var($photo, FILTER_VALIDATE_BOOLEAN);

        $genealogy = $this->fetchGenealogy($animal->id, $gens);

        $flatGenealogy = $genealogy->flatten(1);

        $mother = $flatGenealogy->firstWhere('id', $animal->mother_id);
        $father = $flatGenealogy->firstWhere('id', $animal->father_id);

        return view('admin.animals.show', compact('animal', 'mother', 'father', 'gens', 'photo', 'genealogy'));
    }


    private function fetchGenealogy($animalId, $maxGenerations)
    {
        $query = <<<SQL
            WITH RECURSIVE genealogy_tree AS (
                SELECT
                    id, name, "isMale", father_id, mother_id, "birthDate", "images", breed, 1 AS generation
                FROM animals
                WHERE id = :animalId
                UNION ALL
                SELECT
                    a.id, a.name, a."isMale", a.father_id, a.mother_id, a."birthDate", a."images", a.breed, gt.generation + 1
                FROM animals a
                INNER JOIN genealogy_tree gt ON (a.id = gt.father_id OR a.id = gt.mother_id)
                WHERE gt.generation < :maxGenerations
            )
            SELECT * FROM genealogy_tree ORDER BY generation, id;
        SQL;

        $results = collect(DB::select($query, [
            'animalId' => $animalId,
            'maxGenerations' => $maxGenerations,
        ]));

        return $results->map(function ($row) {
            $row->images = $row->images ? json_decode($row->images, true) : [];
            $row->breed = $row->breed ?? 'Unknown';
            return $row;
        })->groupBy('generation');
    }


    public function edit(Animal $animal)
    {
        $maleAnimals = Animal::where('isMale', true)->where('id', '!=', $animal->id)->get();
        $femaleAnimals = Animal::where('isMale', false)->where('id', '!=', $animal->id)->get();

        $allAnimals = Animal::where('id', '!=', $animal->id)
            ->when(
                $animal->birthDate,
                fn($query) => $query->where(function ($q) use ($animal) {
                    $q->where('birthDate', '<', $animal->birthDate)
                        ->orWhereNull('birthDate');
                })
            )
            ->get();
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
}
