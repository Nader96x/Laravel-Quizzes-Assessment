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
            @role("user")

            <div class="col-md-12 h4">
                Time To Expire: <span class="text-primary" id="timer"></span>
{{--                <a class="btn btn-primary" href="{{ route('exams.index') }}">--}}
{{--                    <i class="fas fa-arrow-left"></i> Back to Quizzes--}}
{{--                </a>--}}
            </div>

            <div class="col-md-12">
                <p id="message" class="h4 text-danger"></p>
            </div>
            <hr/>
            @endrole
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table text-center align-middle" id="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Choices</th>
{{--                        <th>Created At</th>--}}

                    </tr>
                    </thead>
                    <tbody>

                    <?php $i=1;?>

                    @foreach($questions as $question)
{{--                        @dd($question)--}}
                        <tr>

                            <td>{{ $i++ }}</td>
                            <td style="text-align: left;">{{ $question->content }}</td>
                            <td style="text-align: left;" >
                                <ul>
                                        <?php $qid = $question->id;?>
<?php $answer = $answers->first(function ($answer)use($qid){ return $answer?->question_id == $qid;});?>

                                    @foreach($question->choices as $choice)
                                            <?php $ch_id = $choice->id;?>
                                        <div class="form-check" id="{{$qid}}">
                                        <input @disabled($exam->ended_at) @checked($answer?->question_id == $qid && $answer?->choice_id == $ch_id) type="radio" name="answer-{{$qid}}" id="{{"q-$qid-ch-$ch_id"}}" value="{{$ch_id}}" required>
                                        <label for="{{"q-$qid-ch-$ch_id"}}" @class(['bg-success text-light'=>$choice->is_correct && ($exam->ended_at || \Illuminate\Support\Facades\Auth::user()->hasRole("admin"))])>{{ $choice->content }}</label>
                                        </div>
                                    @endforeach
                                </ul>
{{--                            <td>{{ $question->created_at }}</td>--}}

                        </tr>

                    @endforeach
                    @role("user")
                    @if(!$exam->ended_at)
                    <tr>
                        <td colspan="4">
                            <form action="{{route('exams.update',$exam->id)}}" method="POST">
                                @csrf
                                @method("PATCH")
                                <input type="hidden" name="finished" value="1"/>
                                <button class="btn btn-primary w-50" >Finish</button>

                            </form>
                        </td>
                    </tr>
                    @endif
                    @endrole
                    </tbody>
                </table>
            </div>



        </div>
    </div>
@endsection

@push("scripts")

    <script>
        window.onload = function() {
            let deadline = new Date("{{$exam->deadline}}").getTime();
            {{--console.log(deadline,"{{$exam->deadline}}")--}}
            let x = setInterval(function() {
                //now in UTC +00
                let now = new Date().getTime()+new Date().getTimezoneOffset()*60*1000;
                // console.log(now)
                let t = deadline - now;
                let minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((t % (1000 * 60)) / 1000);
                document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";
                if (t < 0) {
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "EXPIRED";
                    // document.getElementById("submit").click();
                }
            }, 1000);


            let choices = document.querySelectorAll("input[type=radio]");
            choices.forEach((choice)=>choice.addEventListener('click',function (e) {
                let question_id = e.target.parentElement.id;
                let choice_id = e.target.value;
                let exam_id = {{$exam->id}};
                let url = "{{route('answers.update')}}";
                let data = {question_id,choice_id,exam_id,_method:'PUT'};
                console.log(data);
                fetch(url,{
                    method:'POST',
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json',
                        'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body:JSON.stringify(data)
                }).then((response) => {
                    return response.json(); // Assuming the response is JSON data
                }).then((data)=>{
                    console.log(data);
                    if(data.message)document.getElementById("message").innerHTML = data.message;
                    if(!data.success) window.location.reload();
                }).catch((error)=>{
                    document.getElementById("message").innerHTML = "Error: "+error;
                    window.location.reload();
                })
            }))

        }

    </script>
@endpush

