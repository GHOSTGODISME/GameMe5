<?php

namespace Database\Seeders;

use App\Models\FortuneWheel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FortuneWheelSeeder extends Seeder
{
    public function run(): void
    {
        FortuneWheel::create([
            'title' => 'RSW3G5',
            'entries' => ['name1', 'name2', 'name3'],
            'results' => [],
            'id_lecturer' => 1,
        ]);
    }
}
