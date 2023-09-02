<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request)
    {
        $exam = Exam::find($request->exam_id);

        if(!$exam) {
            return response()->json([
                'success' => false,
                'message' => 'Exam not found.',
            ]);
        }

        if($exam->ended_at != null) {
            return response()->json([
                'success' => false,
                'message' => 'Exam has ended.',
            ]);
        }

        if ($exam->created_at->addMinutes(20) < now() && $request->json()) {
            return response()->json([
                'success' => false,
                'message' => 'Time limit exceeded.',
            ]);
        }

        if (Auth::user()->id != $exam->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'You can\'t access this exam.',
            ]);
        }

        Answer::updateOrCreate([
            'question_id' => $request->question_id,
            'user_id' => Auth::user()->id,
            'exam_id' => $request->exam_id,
        ], [
            'choice_id' => $request->choice_id,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }


}
