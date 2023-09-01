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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnswerRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request)
    {
//        $exam = Exam::first()->where(["id"=>$id])->get();
//        dd($exam->f);

//        if(!$exam) return redirect()->route('exams.index')->with("error","there is no exam with this ID.");
//        dd([
//            'question_id' => $request->question_id,
//            'user_id' => Auth::user()->id,
//            'exam_id' => $id,
//            'choice_id' => $request->choice_id,
//        ]);
        Answer::updateOrCreate([
            'question_id' => $request->question_id,
            'user_id' => Auth::user()->id,
            'exam_id' => $request->exam_id,
        ], [
            'choice_id' => $request->choice_id,
        ]);

        return response()->json([
            'success' => true,
//            'message' => 'Answer saved successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
