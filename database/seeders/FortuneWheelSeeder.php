<?php

namespace Database\Seeders;

use App\Models\FortuneWheel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FortuneWheelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FortuneWheel::factory()->count(5)->create([
            "id_lecturer" => 1,
        ]);
    }
}
