<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = FakerFactory::create();

        // Generate the youngest generation (leaves of the tree)
        $youngestGeneration = $this->generateYoungestGeneration($faker, 1); // 10 animals in youngest generation

        // Build the tree upwards to the oldest generation
        foreach ($youngestGeneration as $animal) {
            $this->generateParents($faker, $animal, 1, 8); // Build up to 7 generations
        }
    }

    private function generateYoungestGeneration($faker, $count)
    {
        $generation = [];

        foreach (range(1, $count) as $i) {
            $animal = Animal::factory()->create([
                // Generate birthdates for youngest animals (1 to 50 years old)
                'birthDate' => now()->subYears(rand(1, 50)), // Randomly between 1 and 50 years ago
            ]);

            $generation[] = $animal;
        }

        return $generation;
    }

    private function generateParents($faker, $child, $currentGen, $maxGen)
    {
        if ($currentGen >= $maxGen) {
            return; // Stop recursion when max generation is reached
        }

        // Determine valid birthdate range for parents
        $parentBirthStart = $child->birthDate->subYears(10); // At most 50 years older than child
        $parentBirthEnd = $child->birthDate->subYears(5);  // At least 10 years older than child

        // Validate the range
        if ($parentBirthEnd <= $parentBirthStart) {
            $parentBirthStart = $parentBirthEnd->subYears(5); // Ensure valid range for parents
        }

        // Create the mother
        $mother = Animal::factory()->create([
            'isMale' => false, // Female
            'name' => $faker->firstName('female'),
            'birthDate' => $faker->dateTimeBetween($parentBirthStart, $parentBirthEnd),
        ]);

        // Create the father
        $father = Animal::factory()->create([
            'isMale' => true, // Male
            'name' => $faker->firstName('male'),
            'birthDate' => $faker->dateTimeBetween($parentBirthStart, $parentBirthEnd),
        ]);

        // Assign the parents to the child
        $child->update([
            'mother_id' => $mother->id,
            'father_id' => $father->id,
        ]);

        // Continue generating the parents' parents
        $this->generateParents($faker, $mother, $currentGen + 1, $maxGen);
        $this->generateParents($faker, $father, $currentGen + 1, $maxGen);
    }


}
