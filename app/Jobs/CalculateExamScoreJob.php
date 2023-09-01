<?php

namespace App\Jobs;

use App\Mail\AdminMail;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class CalculateExamScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(public Exam $exam)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $exam = Exam::find($this->exam->id);
        if(isset($exam->score)) {
            return;
        }
        $score = 0;
        foreach ($exam->answers as $answer) {
            if ($answer->choice->is_correct) {
                $score += 1;
            }
        }

        $data = [
            'score' => $score,
            'status' => $score * 2 >= $exam->quiz->questions->count() ? "Accepted" : "Rejected",
        ];
        if (!$exam->ended_at){
            $data['ended_at'] = now();
        }
        $exam->update($data);

        // send email to admin
//        Mail::to($exam->user->email)
        Mail::to(User::role('admin')->first()->email)
            ->cc(User::role('admin')->get()->pluck('email'))
            ->queue(new AdminMail($exam));

    }
}
