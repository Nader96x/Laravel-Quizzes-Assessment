<?php

namespace App\Http\Middleware;

use App\Models\Choice;
use App\Models\Exam;
use App\Models\Question;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidAnswer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $exam = Exam::find($request->exam_id);

        // Validated From Previous Middleware
        if(!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Exam not found.',
            ]);
        }

        $question = Question::find($request->question_id);
        if(!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found.',
            ]);
        }

        $choice = Choice::find($request->choice_id);
        if(!$choice) {
            return response()->json([
                'success' => false,
                'message' => 'Choice not found.',
            ]);
        }


        // check if question belongs to exam
        if($question->quiz_id != $exam->quiz_id) {
            return response()->json([
                'success' => false,
                'message' => 'Question not made for this exam.',
            ]);
        }


        // check if choice belongs to question
        if($choice->question_id != $question->id) {
            return response()->json([
                'success' => false,
                'message' => 'Choice not made for this question.',
            ]);
        }

        return $next($request);
    }
}
