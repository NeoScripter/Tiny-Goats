<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Animal;
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

        $genealogy = $this->fetchGenealogy($animal->id, $gens);

        $flatGenealogy = $genealogy->flatten(1);

        $mother = $flatGenealogy->firstWhere('id', $animal->mother_id);
        $father = $flatGenealogy->firstWhere('id', $animal->father_id);

        return view('users.animal-card', compact('animal', 'mother', 'father', 'gens', 'photo', 'genealogy'));
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

        $mother = Animal::find($mother_id) ?? null;
        $father = Animal::find($father_id) ?? null;

        $motherGenealogy = $mother_id ? $this->fetchGenealogy($mother_id, $gens) : collect([]);
        $fatherGenealogy = $father_id ? $this->fetchGenealogy($father_id, $gens) : collect([]);


        return view('users.coupling', compact(
            'gens',
            'photo',
            'motherGenealogy',
            'fatherGenealogy',
            'maleAnimals',
            'femaleAnimals',
            'mother',
            'father'
        ));
    }
}
