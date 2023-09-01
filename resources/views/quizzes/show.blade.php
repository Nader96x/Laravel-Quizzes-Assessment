@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Quiz #{{$quiz->id}}: {{$quiz->title}}</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="{{ route('quizzes.index') }}">
                    <i class="fas fa-arrow-left"></i> Back to Quizzes
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <p id="new-question-btn" class="btn btn-success">
                    <i class="fas fa-arrow-left"></i> Create Question
                </p>
                @include('partials.flash-message')
                {{--                    @include('partials.errors')--}}
                <div id="new-question-form" @class([
                    "d-none" => !$errors->any()
                ])>


                    <form
                    action="{{ route('questions.store') }}"
                    method="POST"
                    class="border p-5 mt-3 mb-3">
                    @csrf
                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                    <div class="form-group">
                        <label for="content">Question : </label>
                        <input type="text" class="form-control" id="content" name="content" value="{{old("content")}}" required>
                        @error('content')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @for($i = 1; $i <= 4; $i++)
                        <div class="form-group">
                            <label for="content">Choice {{$i}}</label>
                            <input type="radio" @checked(old("is_correct") == $i) name="is_correct" value="{{$i}}" required>
                            <input type="text"  id="content" name="choices[{{$i}}][content]" value="{{old("choices.$i.content")}}" required>
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
        <div class="row">
            <div class="col-md-12">
                <table class="table text-center align-middle" id="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Choices</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quiz->questions as $question)
{{--                        @dd($question)--}}
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td>{{ $question->content }}</td>
                            <td>
                                <ul>
                                    @foreach($question->choices as $answer)
                                        <li @class(['bg-success text-light'=>$answer->is_correct])>{{ $answer->content }}</li>
                                    @endforeach
                                </ul>
                            <td>{{ $question->created_at }}</td>
                            <td>
                                <div class="d-flex justify-content-around">
                                    <a class="btn btn-info btn-sm mr-2" href="{{ route('questions.edit', $question->id) }}">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mr-2">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push("scripts")

    <script>
        const form = document.getElementById("new-question-form");

        document.getElementById("new-question-btn").addEventListener("click", function () {

            form.classList.toggle("d-none");
        });

    </script>
@endpush

