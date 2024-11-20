<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;

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
        ->paginate(20);

        return view('users.animals', compact('animals'));
    }
    public function show(Animal $animal, Request $request)
    {
        $gens = $request->query('gens', 3);
        $photo = $request->query('photo', true);

        $gens = is_numeric($gens) && $gens >= 1 && $gens <= 7 ? (int) $gens : 3;

        $photo = filter_var($photo, FILTER_VALIDATE_BOOLEAN);

        function fetchGenerations($animal, $currentGen, $maxGen, &$memo)
        {
            if ($currentGen > $maxGen) {
                return;
            }

            if (!$animal) {
                $memo[$currentGen - 1][] = null;
                $memo[$currentGen - 1][] = null;

                fetchGenerations(null, $currentGen + 1, $maxGen, $memo);
                fetchGenerations(null, $currentGen + 1, $maxGen, $memo);
                return;
            }

            if (!isset($memo[$currentGen - 1])) {
                $memo[$currentGen - 1] = [];
            }

            $mother = Animal::find($animal->mother_id);
            $father = Animal::find($animal->father_id);

            $memo[$currentGen - 1][] = $mother;
            $memo[$currentGen - 1][] = $father;

            fetchGenerations($mother, $currentGen + 1, $maxGen, $memo);
            fetchGenerations($father, $currentGen + 1, $maxGen, $memo);
        }

        $genealogy = [];
        fetchGenerations($animal, 1, $gens, $genealogy);

        $mother = Animal::find($animal->mother_id);
        $father = Animal::find($animal->father_id);


        return view('users.animal-card', compact('animal', 'mother', 'father', 'gens', 'photo', 'genealogy'));
    }
}
