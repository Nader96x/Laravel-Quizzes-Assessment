<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::all()->sortByDesc('id');
        if (request()->ajax()) {
            return datatables()->collection($quizzes)->toJson();
        }
        return view('quizzes.index',compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {

        $quiz = Quiz::create($request->validated());

        return redirect()->route('quizzes.show',$quiz->id)->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->validated());

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
