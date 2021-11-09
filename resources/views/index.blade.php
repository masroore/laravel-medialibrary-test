@extends('app')

@section('content')
    <div class="container">
        <table class="table">
            <thead>
            <th>Name</th>
            <th>File</th>
            <th></th>
            </thead>
            <tbody>
            @foreach($replies as $reply)
                <tr>
                    <td>{{ $reply->name }}</td>
                    <td>
                        @foreach($reply->attachments as $file)
                            <a href="{{ $file->getUrl() }}" target="_blank"><img src="{{ $file->thumbnail }}" alt=""></a>
                        @endforeach
                    </td>
                    <td>
                        <a class="btn btn-xs btn-info" href="{{ route('reply.edit', $reply->id) }}">
                            Edit
                        </a>

                        <form action="{{ route('reply.destroy', $reply->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('reply.create') }}">Create</a>
    </div>
@endsection
