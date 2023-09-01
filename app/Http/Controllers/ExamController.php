<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Exam;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Auth::user()->exams()->get();

        $history = $exams->filter(fn ($exam) => $exam->ended_at != null);
        $progressing = $exams->filter(fn ($exam) => $exam->ended_at == null);

        $available = Quiz::all()->where("status",'=',true)->whereNotIn('id', $exams->pluck('quiz_id'));
        return view('exams.index', compact('history', 'progressing','available'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('exams.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExamRequest $request)
    {
        // CHECK IF USER HAS ALREADY TAKEN THE QUIZ
        if (Auth::user()->exams()->where('quiz_id', $request->quiz_id)->exists()) {
            return redirect()->route('exams.index')->with('error', 'You have already taken this quiz.');
        }

        // CHECK IF USER IS TAKING THE QUIZ WITHIN THE TIME LIMIT
        if (Auth::user()->exams()->where('created_at', '>=', now()->subMinutes(20))->exists()) {
            return redirect()->route('exams.index')->with('error', 'You can only take one quiz at a time.');
        }
        DB::transaction(function () use ($request) {
            $exam = Exam::create([
                'user_id' => Auth::user()->id,
                'quiz_id' => $request->quiz_id,
                'ended_at' => null,
            ]);

            $exam->quiz->questions()->get()->each(function ($question) use ($exam) {
                $exam->answers()->create([
                    'question_id' => $question->id,
                    'user_id' => Auth::user()->id,
                    'exam_id' => $exam->id,
                ]);
            });
        });
        $exam = Exam::where('user_id', Auth::user()->id)->where('quiz_id', $request->quiz_id)->first();
        return redirect()->route('exams.show', $exam);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        $quiz = $exam->quiz;
        $questions = $quiz->questions()->with('choices')->get();
        return view('exams.show', compact('exam', 'quiz', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        return redirect()->route('exams.show', $exam);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExamRequest $request, Exam $exam)
    {
        if($exam->ended_at != null){
            return redirect()->route('exams.show', $exam)->with('error', 'You have already submitted this exam.');
        }

        if ($exam->created_at->addMinutes(20) < now()) {
            return redirect()->route('exams.show', $exam)->with('error', 'You have exceeded the time limit.');
        }
        if ($request->has('finish') && $request->finished) {
            $exam->update([
                'ended_at' => now(),
            ]);
            return redirect()->route('exams.index')->with('success', 'Exam submitted successfully.');
        }

        $exam->answers()->updateOrCreate([
            'question_id' => $request->question_id,
            'user_id' => Auth::user()->id,
            'exam_id' => $exam->id,
        ], [
            'choice_id' => $request->choice_id,
        ]);

        return redirect()->route('exams.show', $exam);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        return redirect()->route('exams.index');
    }
}
