<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'status',
        'ended_at',
    ];

    public function quiz()
    {
        //with trashed
        return $this->belongsTo(Quiz::class)->withTrashed();
    }

    public function questions()
    {
        return $this->quiz->questions;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
         return $this->hasMany(Answer::class);
    }

    public function getDeadlineAttribute(){
        return $this->ended_at??$this->created_at->addMinute(20);
    }
}
