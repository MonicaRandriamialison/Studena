<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tutor;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Level;
use App\Models\Availability;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class TutorStudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        $subjects = Subject::all();
        $levels   = Level::all();

        // 10 tuteurs
        for ($i = 0; $i < 10; $i++) {
            $tutor = Tutor::create([
                'full_name'        => $faker->name(),
                'bio'              => $faker->sentence(),
                'experience_years' => $faker->numberBetween(0, 10),
            ]);

            $tutor->subjects()->attach(
                $subjects->random(rand(1, 3))->pluck('id')->toArray()
            );

            $tutor->levels()->attach(
                $levels->random(rand(1, 3))->pluck('id')->toArray()
            );

            $this->createRandomAvailabilities($tutor, $faker);
        }

        // 50 élèves
        for ($i = 0; $i < 50; $i++) {
            $student = Student::create([
                'full_name' => $faker->name(),
                'level'     => $levels->random()->name,
            ]);

            $student->subjects()->attach(
                $subjects->random(rand(1, 2))->pluck('id')->toArray()
            );

            $this->createRandomAvailabilities($student, $faker);
        }
    }

    private function createRandomAvailabilities($owner, $faker): void
    {
        $slotsCount = rand(1, 3);

        for ($i = 0; $i < $slotsCount; $i++) {
            $day  = $faker->numberBetween(0, 6);
            $hour = $faker->numberBetween(8, 18);

            Availability::create([
                'owner_type'  => get_class($owner) === Tutor::class ? 'tutor' : 'student',
                'owner_id'    => $owner->id,
                'day_of_week' => $day,
                'start_time'  => sprintf('%02d:00:00', $hour),
                'end_time'    => sprintf('%02d:00:00', $hour + 2),
            ]);
        }
    }
}
