<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidExam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $exam = $request->exam;
//        dd($exam);

        if (Auth::user()->id != $exam->user_id)
            return redirect()->back()->with("error","You can't access this Exam.");


        if($exam->ended_at != null){
            return redirect()->back()->with('error', 'You have already submitted this exam.');
        }
        // if user hits finish the quiz after more than 20 minutes
        if ($exam->created_at->addMinutes(20) < now() && $request->json())
            return redirect()->back()->with('error', 'You have already submitted this exam.');


        return $next($request);
    }
}
