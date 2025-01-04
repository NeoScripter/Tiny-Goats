<?php

namespace Database\Seeders;

use App\Models\LogEntry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LogEntry::factory()->count(90)->create();
    }
}
