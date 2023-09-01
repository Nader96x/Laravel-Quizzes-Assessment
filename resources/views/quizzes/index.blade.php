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
                            <th width="20%">Created At</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->id }}</td>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->created_at }}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a class="btn btn-success btn-sm mr-2" href="{{ route('quizzes.show', $quiz->id) }}">
                                            <i class="fas fa-eye"></i> Show Details
                                        </a>
                                        <a class="btn btn-info btn-sm mr-2" href="{{ route('quizzes.edit', $quiz->id) }}">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST">
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

@push('scripts')
<script>
    $('table').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('quizzes.index') }}",
        columns: [
            {data: 'id'},
            {data: 'title'},
            {
                data: 'created_at', render: function (data, type, full, meta) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                data: 'id', orderable: false, searchable: false,
                render: function (data, type, full, meta) {
                    var html = `
                        <div class="d-flex  ">
                            <a class="btn btn-info btn-sm mr-2" href="{{ route('quizzes.edit', ':id') }}">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm mr-2" onclick="sweetDelete(event)"
                                    data-id="${data}">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </div>
    `;

                    return html.replaceAll(':id', data);
                }
            },

        ]
    })
    ;
</script>

@endpush
