@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit Quiz #{{$quiz->id}}</h1>
                <hr>
                @include('partials.flash-message')
{{--                @include('partials.errors')--}}
                <form method="POST" action="{{ route('quizzes.update',$quiz->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$quiz->title}}" required>
                        @error('title')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
