<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = ['Collège', 'Lycée', 'Terminale'];

        foreach ($levels as $name) {
            Level::create(['name' => $name]);
        }
    }
}
