<?php

namespace App\Jobs;

use App\Models\Exam;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateExamScore implements ShouldQueue
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
        $score = 0;
        foreach ($this->exam->answers as $answer) {
            if ($answer->choice->is_correct) {
                $score += 1;
            }
        }

        $data = [
            'score' => $score,
        ];
//        if (!$this->exam->ended_at)
//            $data['ended_at'] = now();
        $this->exam->update($data);
    }
}
