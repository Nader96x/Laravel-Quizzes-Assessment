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


                @include('questions.create')
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
                    <?php $questions = $quiz->questions()->get()->sortByDesc('id');?>
                    <?php $i=1;?>

                    @foreach($questions as $question)
{{--                        @dd($question)--}}
                        <tr>
                            <td>{{ $i++ }}</td>
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
                                        <button type="submit" name="deleteBtn" class="btn btn-danger btn-sm mr-2">
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

        function confirmDelete(e){
            const result =  confirm("Are you sure you want to delete this question?");
            if(result){
                return true;
            }else{
                e.preventDefault();
            }
        }
        deleteBtns = document.getElementsByName("deleteBtn");
        deleteBtns.forEach(btn => {
            btn.addEventListener('click',confirmDelete);
        });


        const form = document.getElementById("new-question-form");

        document.getElementById("new-question-btn").addEventListener("click", function () {

            form.classList.toggle("d-none");
        });

    </script>
@endpush

