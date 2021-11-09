@extends('app')

@section('content')
    <div class="container">
        <form action="{{ route("reply.store") }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="document_file">Documents</label>
                <div class="needsclick dropzone" id="document_file-dropzone"></div>
            </div>
            <div>
                <input class="btn btn-danger" type="submit">
            </div>
        </form>
    </div>
@endsection


@section('scripts')
    @include('_script-setup')
    <script src="{{ asset('js/dropz.js') }}"></script>
@stop


