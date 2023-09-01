@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-12">
                <h1>Exams</h1>
                <hr>
                @include('partials.flash-message')
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Exam Title</th>
                            <th>Student</th>
                            <th width="15%">Created At</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($exams as $exam)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $exam->quiz->title }}</td>
                                <td>{{ $exam->user->name }}</td>
                                <td>{{ $exam->created_at }}</td>

                                <td>
                                    <div class="d-flex justify-content-around">
                                            <a class="btn btn-primary btn-sm mr-2" href="{{ route('exams.show',$exam->id) }}">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if(!$exams->count())
                            <tr>
                                <td colspan="6" class="text-center h3">No Data Yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
       {{-- <div class="row mt-5">
            <div class="col-md-12">
                <h1>Processing Quizzes</h1>
                <hr>
--}}{{--                @include('partials.flash-message')--}}{{--
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
        --}}
    </div>
@endsection
