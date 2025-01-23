<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('SuperSecureAdmin!123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $names = [
            'GoatGuru', 'BreedingExpert', 'FlockMaster', 'GoatKeeper', 'FarmHaven',
            'PastureKing', 'NannyWhisperer', 'HerdHero', 'BarnInnovator', 'CaprineCraft',
            'DoeDreamer', 'BillyPro', 'BuckGuardian', 'HoofHaven', 'MilkMate',
            'GoatTales', 'CaprineCove', 'DoeDynasty', 'PasturePal', 'GoatWizard'
        ];

        $domains = ['goatherd.com', 'breeders.net', 'caprinefarm.com', 'pasturelife.org', 'goatworld.com'];

        foreach ($names as $name) {
            $password = self::generateSecurePassword();

            User::create([
                'name' => $name,
                'email' => Str::slug($name) . '@' . $domains[array_rand($domains)],
                'password' => Hash::make($password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            echo "User: {$name}, Email: " . Str::slug($name) . '@' . $domains[array_rand($domains)] . ", Password: {$password}\n";
        }
    }

    /**
     * Generate a secure, user-friendly password
     *
     * @return string
     */
    private static function generateSecurePassword(): string
    {
        $words = ['Goat', 'Farm', 'Hero', 'Pasture', 'Doe', 'Buck', 'Breeder', 'Milk', 'Herd', 'Flock'];
        $specialChars = ['!', '@', '#', '$', '%', '&', '*'];
        $randomWord1 = $words[array_rand($words)];
        $randomWord2 = $words[array_rand($words)];
        $randomNumber = random_int(10, 99);
        $specialChar = $specialChars[array_rand($specialChars)];

        return "{$randomWord1}{$randomWord2}{$randomNumber}{$specialChar}";
    }
}
