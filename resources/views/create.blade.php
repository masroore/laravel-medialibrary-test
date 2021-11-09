@extends('app')

@section('content')
    <div class="container">
        <form action="{{ route("reply.store") }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Name*</label>
                <input type="text" id="name" name="name" class="form-control"
                       value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>

            <div class="form-group {{ $errors->has('document_file') ? 'has-error' : '' }}">
                <label for="document_file">File*</label>
                <div class="needsclick dropzone" id="document_file-dropzone"></div>
                @if($errors->has('document_file'))
                    <p class="help-block">
                        {{ $errors->first('document_file') }}
                    </p>
                @endif
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


