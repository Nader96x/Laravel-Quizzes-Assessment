@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit Question</h1>
                <hr>
                <a class="btn btn-primary" href="{{ route('quizzes.show',$question->quiz_id) }}">
                    <i class="fas fa-arrow-left"></i> Back to Quiz
                </a>
                <hr>
                @include('partials.flash-message')
{{--                @include('partials.errors')--}}
                <form
                    action="{{ route('questions.update',$question->id) }}"
                    method="POST"
                    class="border p-5 mt-3 mb-3">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="quiz_id" value="{{ $question->quiz_id }}">
                    <?php $choices = $question->choices()->get();?>
                    <div class="form-group">
                        <label for="content">Question : </label>
                        <input type="text" class="form-control" id="content" name="content" value="{{$question->content}}" required>
                        @error('content')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @for($i = 1; $i <= 4; $i++)
                        <div class="form-group">
                            <label for="content">Choice {{$i}}</label>
                            <input type="radio" @checked($choices[$i-1]['is_correct']) name="is_correct" value="{{$i}}" required>
                            <input type="text"  id="content" name="choices[{{$i}}][content]" value="{{$choices[$i-1]['content']}}" required>
                            @error("choices.$i.content")
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endfor

                    <button type="submit" class="btn btn-primary mt-3">Save</button>



                </form>
            </div>
        </div>
    </div>
@endsection
