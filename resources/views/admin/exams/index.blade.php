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
                            <th>Status</th>
                            <th>Score</th>
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
                                <td @class([
                                        "text-success" => $exam->status == "Accepted",
                                        "text-danger"  => $exam->status == "Rejected",
        ]                           )>{{ $exam->status }}</td>
                                <td>{{ isset($exam->score) ? $exam->score."/".$exam->quiz->questions->count() : "" }} {{ isset($exam->score)?  "(".($exam->score / $exam->quiz->questions->count() * 100)."%)":"" }}</td>
                                <td>{{ $exam->created_at }}</td>

                                <td>
                                    <div class="d-flex justify-content-around ">
                                            <a class="btn btn-primary btn-sm mr-2" href="{{ route('exams.show',$exam->id) }}">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @if(isset($exam->score))
                                        <form action="{{ route('exams.sendmail', $exam->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm mr-2">
                                                <i class="fas fa-envelope"></i> Send Mail
                                            </button>
                                        </form>
                                            @endif
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
    </div>
@endsection
