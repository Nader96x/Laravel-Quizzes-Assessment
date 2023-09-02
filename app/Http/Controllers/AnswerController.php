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
