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
                            <th>Total Questions</th>
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
                                <td>{{ $quiz->questions->count() }}</td>
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

                        @if(!$available->count())
                            <tr>
                                <td colspan="6" class="text-center h3">No Data Yet.</td>
                            </tr>
                        @endif
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
                                            <i class="fas fa-eye"></i> Continue
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @endforeach

                        @if(!$progressing->count())
                            <tr>
                                <td colspan="6" class="text-center h3">No Data Yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row  mt-5">
            <div class="col-md-12">
                <h1>Your Result History</h1>
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
                            <th width="15%">Submited At</th>
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
                                <td @class([
                                        "text-success" => $exam->status == "Accepted",
                                        "text-danger"  => $exam->status == "Rejected",
        ]                           )>{{ $exam->status??"Pending" }}</td>
                                <td>{{ $exam->created_at }}</td>
                                <td>{{ $exam->ended_at }}</td>

                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a class="btn btn-success btn-sm mr-2" href="{{ route('exams.show', $exam->id) }}">
                                            <i class="fas fa-eye"></i> Show Results
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if(!$history->count())
                            <tr>
                                <td colspan="6" class="text-center h3">No Data Yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
