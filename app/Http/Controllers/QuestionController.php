<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {

        $choices = collect($request->choices)->map(function($choice, $key)use( $request){
            return [
                'content'=> $choice['content'],
                'is_correct'=> $key == $request->is_correct,
            ];
        })->toArray();

        DB::Transaction(function() use($choices, $request){
            $question = Question::create($request->validated());
            $question->choices()->createMany($choices);
        });

        return redirect()->route('quizzes.show', $request->quiz_id)->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return redirect()->route('quizzes.show', $question->quiz_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $choices = collect($request->choices)->map(function($choice, $key)use( $request){
            return [
                'content'=> $choice['content'],
                'is_correct'=> $key == $request->is_correct,
            ];
        })->toArray();

        DB::Transaction(function() use($choices, $request, $question){
            $question->choices()->delete();
            $question->choices()->createMany($choices);
        });

        return redirect()->route('quizzes.show', $question->quiz_id)->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('quizzes.show', $question->quiz_id)->with('success', 'Question deleted successfully.');
    }
}
