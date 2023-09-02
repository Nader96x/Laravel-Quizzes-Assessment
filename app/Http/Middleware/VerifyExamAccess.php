<?php

namespace App\Http\Middleware;

use App\Models\Exam;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyExamAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,bool $json=false): Response
    {
        $exam = Exam::find($request->exam_id);

        if(!$exam) {
            if ($json) return response()->json([
                'success' => false,
                'message' => 'Exam not found.',
            ]);
            return redirect()->back()->with('error', 'Exam not found.');
        }

        // check if this is same user who created the exam
        if (Auth::user()->id != $exam->user_id) {
            if ($json) return response()->json([
                'success' => false,
                'message' => 'You can\'t access this exam.',
            ]);
            return redirect()->back()->with("error","You can't access this Exam.");
        }

        // check if the exam is finished by user or time limit exceeded
        if($exam->ended_at != null) {
            if ($json) return response()->json([
                'success' => false,
                'message' => 'Exam has ended.',
            ]);
            return redirect()->back()->with('error', 'You have already submitted this exam.');
        }

        // check if exam is created expired
        if ($exam->created_at->addMinutes(20) < now() && $request->json()) {
            if ($json) return response()->json([
                'success' => false,
                'message' => 'Time limit exceeded.',
            ]);
            return redirect()->back()->with('error', 'Time limit exceeded.');
        }


        return $next($request);
    }
}
