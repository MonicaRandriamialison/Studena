<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Http\Request;

class StudentMatchController extends Controller
{
    public function index(Student $student)
    {
        $student->load(['subjects', 'availabilities']);

        $tutors = Tutor::with(['subjects', 'levels', 'availabilities'])->get();

        $matches = $tutors->map(function ($tutor) use ($student) {
            $scoreData = $this->calculateScore($student, $tutor);

            return [
                'tutor'                  => $tutor,
                'score'                  => $scoreData['score'],
                'match_type'             => $scoreData['match_type'],
                'availability_overlap'   => $scoreData['overlap_text'],
            ];
        })->sortByDesc('score')->values();

        return response()->json($matches);
    }

    private function calculateScore(Student $student, Tutor $tutor): array
    {
        $studentSubjects = $student->subjects->pluck('id');
        $tutorSubjects   = $tutor->subjects->pluck('id');

        $commonSubjectsCount = $studentSubjects->intersect($tutorSubjects)->count();
        $allStudentSubjectsCovered = $studentSubjects->diff($tutorSubjects)->isEmpty();

        if ($commonSubjectsCount === 0) {
            return [
                'score'        => 0,
                'match_type'   => 'none',
                'overlap_text' => '',
            ];
        }

        $matchSubjectScore = $allStudentSubjectsCovered ? 1.0 : 0.8;

        $matchLevelScore = $tutor->levels->contains('name', $student->level) ? 1.0 : 0.0;

        $availabilityData = $this->computeAvailabilityOverlap($student, $tutor);

        $availabilityScore = $availabilityData['ratio'];
        $overlapText       = $availabilityData['text'];

        $experienceScore = min($tutor->experience_years / 10, 1);

        $score = 100 * (
            0.4 * $availabilityScore +
            0.3 * $matchSubjectScore +
            0.2 * $matchLevelScore +
            0.1 * $experienceScore
        );

        $matchType = 'partial';
        if ($score >= 80 && $availabilityScore >= 0.8 && $matchLevelScore === 1.0) {
            $matchType = 'perfect';
        } elseif ($score == 0) {
            $matchType = 'none';
        }

        return [
            'score'        => round($score),
            'match_type'   => $matchType,
            'overlap_text' => $overlapText,
        ];
    }

    private function computeAvailabilityOverlap(Student $student, Tutor $tutor): array
    {
        $studentSlots = $student->availabilities;
        $tutorSlots   = $tutor->availabilities;

        if ($studentSlots->isEmpty() || $tutorSlots->isEmpty()) {
            return ['ratio' => 0, 'text' => ''];
        }

        $totalStudentMinutes = 0;
        foreach ($studentSlots as $s) {
            $totalStudentMinutes += $this->minutesBetween($s->start_time, $s->end_time);
        }

        $overlapMinutes = 0;
        $overlapTexts   = [];

        foreach ($studentSlots as $s) {
            foreach ($tutorSlots as $t) {
                if ($s->day_of_week !== $t->day_of_week) {
                    continue;
                }

                $start = max(strtotime($s->start_time), strtotime($t->start_time));
                $end   = min(strtotime($s->end_time), strtotime($t->end_time));

                if ($start < $end) {
                    $minutes = ($end - $start) / 60;
                    $overlapMinutes += $minutes;

                    $overlapTexts[] = sprintf(
                        'Jour %d de %s à %s',
                        $s->day_of_week,
                        date('H:i', $start),
                        date('H:i', $end)
                    );
                }
            }
        }

        if ($totalStudentMinutes == 0) {
            return ['ratio' => 0, 'text' => ''];
        }

        $ratio = max(0, min(1, $overlapMinutes / $totalStudentMinutes));

        return [
            'ratio' => $ratio,
            'text'  => implode(' / ', array_unique($overlapTexts)),
        ];
    }

    private function minutesBetween(string $start, string $end): int
    {
        return (strtotime($end) - strtotime($start)) / 60;
    }
}
