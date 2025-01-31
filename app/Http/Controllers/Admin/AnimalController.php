<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Household;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $gender = $request->query('gender');
        $breed = $request->query('breed');
        $name = Str::title($request->query('name'));
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
        $maleAnimals = Animal::where('isMale', true)->orderBy('name', 'asc')->get();
        $femaleAnimals = Animal::where('isMale', false)->orderBy('name', 'asc')->get();
        $households = Household::all();
        $allAnimals = Animal::all();
        return view('admin.animals.create', compact('maleAnimals', 'femaleAnimals', 'allAnimals', 'households'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:animals,name',
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
            'household_breeder_id' => 'nullable|exists:households,id',
            'household_owner_id' => 'nullable|exists:households,id',
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
        $validated['images'] = count($imagePaths) > 0 ? $imagePaths : null;

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

        $gens = is_numeric($gens) && $gens >= 1 && $gens <= 8 ? (int) $gens : 3;

        $photo = filter_var($photo, FILTER_VALIDATE_BOOLEAN);


        $genealogy = [];
        $this->fetchGenerations($animal, 1, $gens - 1, $genealogy);

        $repeatedIds = $this->getRepeatedIdsFromGenerations($genealogy);

        $colors = Animal::REPEATED_BG_COLORS;

        $repeatedColors = [];
        $colorCount = count($colors);


        foreach ($repeatedIds as $index => $id) {
            $repeatedColors[$id] = $colors[$index % $colorCount];
        }

        $mother = Animal::select('id', 'name', 'mother_id', 'father_id', 'breed', 'images', 'isMale')->find($animal->mother_id);
        $father = Animal::select('id', 'name', 'mother_id', 'father_id', 'breed', 'images', 'isMale')->find($animal->father_id);


        $owner = Household::find($animal->household_owner_id);
        $breeder = Household::find($animal->household_breeder_id);

        return view('admin.animals.show', compact('animal', 'mother', 'father', 'gens', 'photo', 'genealogy', 'repeatedColors', 'owner', 'breeder'));
    }


    private function fetchGenerations($animal, $currentGen, $maxGen, &$memo)
    {
        if ($currentGen > $maxGen) {
            return;
        }
        if (!$animal) {
            $memo[$currentGen - 1][] = null;
            $memo[$currentGen - 1][] = null;

            $this->fetchGenerations(null, $currentGen + 1, $maxGen, $memo);
            $this->fetchGenerations(null, $currentGen + 1, $maxGen, $memo);
            return;
        }

        if (!isset($memo[$currentGen - 1])) {
            $memo[$currentGen - 1] = [];
        }

        $father = Animal::select('id', 'name', 'mother_id', 'father_id', 'breed', 'images', 'isMale')->find($animal->father_id);
        $mother = Animal::select('id', 'name', 'mother_id', 'father_id', 'breed', 'images', 'isMale')->find($animal->mother_id);

        $memo[$currentGen - 1][] = $father;
        $memo[$currentGen - 1][] = $mother;

        $this->fetchGenerations($father, $currentGen + 1, $maxGen, $memo);
        $this->fetchGenerations($mother, $currentGen + 1, $maxGen, $memo);
    }

    private function getRepeatedIdsFromGenerations(array $memo)
    {
        $allIds = [];
        foreach ($memo as $generation) {
            foreach ($generation as $animal) {
                if ($animal) {
                    $allIds[] = $animal->id;
                }
            }
        }

        $idCounts = array_count_values($allIds);

        return array_keys(array_filter($idCounts, fn($count) => $count > 1));
    }


    public function edit(Animal $animal)
    {

        $maleAnimals = Animal::where('isMale', true)->where('id', '!=', $animal->id)->orderBy('name', 'asc')->get();
        $femaleAnimals = Animal::where('isMale', false)->where('id', '!=', $animal->id)->orderBy('name', 'asc')->get();
        $households = Household::all();

        $allAnimals = Animal::where('id', '!=', $animal->id)
            ->when(
                $animal->birthDate,
                fn($query) => $query->where(function ($q) use ($animal) {
                    $q->where('birthDate', '<', $animal->birthDate)
                        ->orWhereNull('birthDate');
                })
            )
            ->get();
        return view('admin.animals.edit', compact('animal', 'maleAnimals', 'femaleAnimals', 'allAnimals', 'households'));
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
            'household_breeder_id' => 'nullable|exists:households,id',
            'household_owner_id' => 'nullable|exists:households,id',
            'children' => 'nullable|array',
            'children.*' => 'exists:animals,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:500',
        ]);


        $validated['forSale'] = $request->has('forSale');
        $validated['showOnMain'] = $request->has('showOnMain');

        $deletedImages = $request->input('deletedImages');

        $indicesToDelete = [];

        for ($i = 0; $i < strlen($deletedImages); $i++) {
            $indicesToDelete[] = (int) $deletedImages[$i];
        }


        $newImages = [];
        $oldImages = $animal->images ?? [];

        foreach ($oldImages as $index => $img) {
            if (!in_array($index, $indicesToDelete)) {
                $newImages[] = $img;
            } else {
                Storage::delete("public/{$img}");
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if (count($newImages) >= 4) break;
                $path = $image->store('animals_images', 'public');
                $newImages[] = $path;
            }
        }

        $validated['images'] = $newImages;

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

        return redirect()->route('animals.show', $animal->id)->with('success', 'Животное успешно обновлено!');
    }


    public function destroy(Animal $animal)
    {
        if (is_array($animal->images)) {
            foreach ($animal->images as $imagePath) {
                if (is_string($imagePath) && !empty($imagePath) && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        $animal->delete();
        return redirect()->route('animals.index')->with('success', 'Животное успешно удалено!');
    }
}
