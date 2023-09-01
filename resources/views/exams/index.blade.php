@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-12">
                <h1>New Quizzes</h1>
                <hr>
                @include('partials.flash-message')
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Exam Title</th>
                            <th width="15%">Created At</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($available as $quiz)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->created_at }}</td>

                                <td>
                                    <div class="d-flex justify-content-around">
                                        <form method="POST" action="{{ route('exams.store') }}">
                                            @csrf
                                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                                            <button class="btn btn-primary btn-sm mr-2">
                                                <i class="fas fa-eye"></i> Take Quiz
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
        <div class="row mt-5">
            <div class="col-md-12">
                <h1>Processing Quizzes</h1>
                <hr>
{{--                @include('partials.flash-message')--}}
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Exam Title</th>
                            <th width="15%">Created At</th>
                            <th width="15%">Deadline</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($progressing as $exam)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $exam->quiz->title }}</td>
                                <td>{{ $exam->created_at }}</td>
                                <td>{{ $exam->deadline }}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a class="btn btn-success btn-sm mr-2" href="{{ route('exams.show', $exam->id) }}">
                                            <i class="fas fa-eye"></i> Show Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row  mt-5">
            <div class="col-md-12">
                <h1>Your Quizzes History</h1>
                <hr>
{{--                @include('partials.flash-message')--}}
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Exam Title</th>
                            <th>Score</th>
                            <th>Result</th>
                            <th width="15%">Created At</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($history as $exam)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $exam->quiz->title }}</td>
                                <td>{{ $exam->score }}</td>
                                <td>{{ $exam->result }}</td>
                                <td>{{ $exam->created_at }}</td>

                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a class="btn btn-success btn-sm mr-2" href="{{ route('quizzes.show', $quiz->id) }}">
                                            <i class="fas fa-eye"></i> Show Details
                                        </a>
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
