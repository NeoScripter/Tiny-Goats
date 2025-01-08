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

        $genealogy = $this->fetchGenealogy($animal->id, $gens);

        $flatGenealogy = $genealogy->flatten(1);

        $repeatedIds = $flatGenealogy->pluck('id')
            ->countBy()
            ->filter(fn($count) => $count > 1)
            ->keys();

        $colors = [
            '#32CD32',
            '#9ACD32',
            '#6B8E23',
            '#556B2F',
            '#8FBC8F',
            '#7CFC00',
            '#BDB76B',
            '#228B22',
            '#F0E68C',
            '#DAA520',
            '#8B4513',
            '#98FB98',
            '#FFDEAD',
            '#DEB887',
            '#006400',
            '#00FF00',
            '#008080',
            '#7FFFD4',
            '#4682B4',
        ];

        $repeatedAnimalColors = [];
        $colorCount = count($colors);

        foreach ($repeatedIds as $index => $id) {
            $repeatedAnimalColors[$id] = $colors[$index % $colorCount];
        }

        $mother = $flatGenealogy->firstWhere('id', $animal->mother_id);
        $father = $flatGenealogy->firstWhere('id', $animal->father_id);

        $owner = Household::find($animal->household_owner_id);
        $breeder = Household::find($animal->household_breeder_id);

        return view('users.animal-card', compact('animal', 'mother', 'father', 'gens', 'photo', 'genealogy', 'repeatedAnimalColors', 'owner', 'breeder'));
    }


    private function fetchGenealogy($animalId, $maxGenerations)
    {
        $query = <<<SQL
            WITH RECURSIVE genealogy_tree AS (
                SELECT
                    id, name, "isMale", father_id, mother_id, "birthDate", "images", breed, 1 AS generation, CAST(1 AS BIGINT) AS position
                FROM animals
                WHERE id = :animalId
                UNION ALL
                SELECT
                    a.id, a.name, a."isMale", a.father_id, a.mother_id, a."birthDate", a."images", a.breed, gt.generation + 1,
                    CAST(
                        gt.position * 2 + (a.id = gt.father_id)::int AS BIGINT
                    ) AS position
                FROM animals a
                INNER JOIN genealogy_tree gt ON (a.id = gt.father_id OR a.id = gt.mother_id)
                WHERE gt.generation < :maxGenerations
            )
            SELECT * FROM genealogy_tree ORDER BY generation, position;
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

        $flatMotherGenealogy = $motherGenealogy->flatten(1);
        $flatFatherGenealogy = $fatherGenealogy->flatten(1);

        $allGenealogy = $flatMotherGenealogy->merge($flatFatherGenealogy);
        $repeatedIds = $allGenealogy->pluck('id')
            ->countBy()
            ->filter(fn($count) => $count > 1)
            ->keys();

        $colors = [
            '#32CD32',
            '#228B22',
            '#006400',
            '#9ACD32',
            '#6B8E23',
            '#556B2F',
            '#8FBC8F',
            '#7CFC00',
            '#BDB76B',
            '#F0E68C',
            '#DAA520',
            '#8B4513',
            '#98FB98',
            '#FFDEAD',
            '#DEB887',
            '#00FF00',
            '#008080',
            '#7FFFD4',
            '#4682B4'
        ];

        $repeatedAnimalColors = [];
        $colorCount = count($colors);

        foreach ($repeatedIds as $index => $id) {
            $repeatedAnimalColors[$id] = $colors[$index % $colorCount];
        }


        return view('users.coupling', compact(
            'gens',
            'photo',
            'motherGenealogy',
            'fatherGenealogy',
            'maleAnimals',
            'femaleAnimals',
            'mother',
            'father',
            'repeatedAnimalColors'
        ));
    }
}
