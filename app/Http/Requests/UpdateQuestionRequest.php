<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'quiz_id'=> 'required|exists:quizzes,id',
            'content'=> 'required|string|max:255|min:3',
            'choices'=> 'required|array|min:4|max:4',
            'choices.*.content'=> 'required|string|max:255|min:1|distinct',
            'is_correct'=> 'required|in:1,2,3,4',
        ];
    }

    public $attributes = [
        'quiz_id'=> 'quiz',
        'content'=> 'question',
        'choices'=> 'choices',
        'choices.*.content'=> 'choice',
        'is_correct'=> 'correct choice',
    ];
}
