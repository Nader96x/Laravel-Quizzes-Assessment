<form
    action="{{ route('questions.store') }}"
    method="POST"
    class="border p-5 mt-3 mb-3">
    @csrf
    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

    <div class="form-group">
        <label class="h3" for="content">Question : </label>
        <input type="text" class="form-control" id="content" name="content" value="{{old("content")}}" required>
        @error('content')
        <small class="text-danger">{{ $message }}</small>
        @enderror
        <hr/>
    </div>
    @for($i = 1; $i <= 4; $i++)
        <div class="form-group">
            <label for="content">Choice {{$i}}</label>
            <input type="radio" @checked(old("is_correct") == $i) name="is_correct" value="{{$i}}" required>
            <input type="text" class="form-control" id="content" name="choices[{{$i}}][content]" value="{{old("choices.$i.content")}}" required>
            @error("choices.$i.content")
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    @endfor

    <button type="submit" class="btn btn-primary mt-3">Save</button>



</form>
