<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quizzes = \App\Models\Quiz::all();
        foreach ($quizzes as $quiz) {
            $quetions = Question::factory()->count(4)->create([
                'quiz_id' => $quiz->id,
            ]);
            foreach ($quetions as $question) {
                $choices = \App\Models\Choice::factory()->count(4)->create([
                    'question_id' => $question->id,

                ]);
                // convert all to is_correct = false
                $choices->each(function ($choice) {
                    $choice->update([
                        'is_correct' => false,
                    ]);
                });
                // make sure only one of the choices is correct
                $choices->random()->update([
                    'is_correct' => true,
                ]);
            }
        }
    }
}
