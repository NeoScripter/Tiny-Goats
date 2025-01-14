<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Household;
use Illuminate\Http\Request;
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

        return view('users.animals', compact('animals'));
    }

    public function show(Animal $animal, Request $request)
    {
        $gens = $request->query('gens', 3);
        $photo = $request->query('photo', true);

        $gens = is_numeric($gens) && $gens >= 1 && $gens <= 7 ? (int) $gens : 3;

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

        $mother = Animal::find($animal->mother_id);
        $father = Animal::find($animal->father_id);

        $owner = Household::find($animal->household_owner_id);
        $breeder = Household::find($animal->household_breeder_id);

        return view('users.animal-card', compact('animal', 'mother', 'father', 'gens', 'photo', 'genealogy', 'repeatedColors', 'owner', 'breeder'));
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

        $father = Animal::find($animal->father_id);
        $mother = Animal::find($animal->mother_id);

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

    public function coupling(Request $request)
    {
        $gens = $request->query('gens', 3);
        $photo = $request->query('photo', true);

        $mother_id = $request->query('mother_id');
        $father_id = $request->query('father_id');

        $gens = is_numeric($gens) && $gens >= 1 && $gens <= 7 ? (int) $gens : 3;
        $photo = filter_var($photo, FILTER_VALIDATE_BOOLEAN);

        $maleAnimals = Animal::where('isMale', true)->get();
        $femaleAnimals = Animal::where('isMale', false)->get();

        $genealogy = [];
        $mother = Animal::find($mother_id) ?? null;
        $father = Animal::find($father_id) ?? null;

        $this->fetchGenerations($father, 2, $gens - 1, $genealogy);
        $this->fetchGenerations($mother, 2, $gens - 1, $genealogy);

        $repeatedIds = $this->getRepeatedIdsFromGenerations($genealogy);

        $colors = Animal::REPEATED_BG_COLORS;

        $repeatedColors = [];
        $colorCount = count($colors);


        foreach ($repeatedIds as $index => $id) {
            $repeatedColors[$id] = $colors[$index % $colorCount];
        }


        return view('users.coupling', compact(
            'gens',
            'photo',
            'genealogy',
            'maleAnimals',
            'femaleAnimals',
            'mother',
            'father',
            'repeatedColors'
        ));
    }
}
