@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Quizzes</h1>
                <a href="{{ route('quizzes.create') }}" class="btn btn-primary">Add Quiz</a>
                <hr>
                @include('partials.flash-message')
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Quiz Title</th>
                            <th>Total Questions</th>
                            <th width="20%">Created At</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($quizzes as $quiz)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->questions->count() }}</td>
                                <td>{{ $quiz->created_at }}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a class="btn btn-primary btn-sm mr-2" href="{{ route('quizzes.show', $quiz->id) }}">
                                            <i class="fas fa-eye"></i> Show Details
                                        </a>
                                        <a class="btn btn-info btn-sm mr-2" href="{{ route('quizzes.edit', $quiz->id) }}">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mr-2">
                                                <i class="fas fa-trash-alt"></i> Deactivate
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        <div class="col-md-12">
                <h1>Deactivated Quizzes</h1>
                <hr>
{{--                @include('partials.flash-message')--}}
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Quiz Title</th>
                            <th>Total Questions</th>
                            <th width="20%">Created At</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($trashed as $quiz)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->questions->count() }}</td>
                                <td>{{ $quiz->created_at }}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a class="btn btn-primary btn-sm mr-2" href="{{ route('quizzes.show', $quiz->id) }}">
                                            <i class="fas fa-eye"></i> Show Details
                                        </a>
                                        <a class="btn btn-info btn-sm mr-2" href="{{ route('quizzes.edit', $quiz->id) }}">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        <form action="{{ route('quizzes.restore', $quiz->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm mr-2">
                                                <i class="fas fa-trash-alt"></i> Activate
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


