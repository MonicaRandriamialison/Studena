<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = ['Mathématiques', 'Physique', 'Français', 'Anglais', 'SVT'];

        foreach ($subjects as $name) {
            Subject::create(['name' => $name]);
        }
    }
}
