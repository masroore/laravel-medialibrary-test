@extends('app')
@section('content')

    <div class="container">
        <table class="table table-borderless table-responsive">
            <tbody>
            @foreach($reply->attachments as $media)
                <tr>
                    <td>
                        <a href="{{ $media->url }}" target="_blank"><img src="{{ $media->preview }}" alt=""></a>
                    </td>
                    <td>
                        <form action="{{ route('media.destroy', $media->uuid) }}" method="POST"
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


        <form action="{{ route("reply.update", [$reply->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control"
                       value="{{ old('name', isset($reply) ? $reply->name : '') }}">
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
                <p class="helper-block">
                    Name
                </p>
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
                <input class="btn btn-danger" type="submit" value="Update">
            </div>
        </form>


    </div>


@endsection

@section('scripts')
    <script>
        Dropzone.options.documentFileDropzone = {
            url: '{{ route('reply.upload') }}',
            maxFilesize: 2, // MB
            maxFiles: 10,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="document_file[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="document_file[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($reply) && $reply->document_file)
                var files = {!! json_encode($reply->document_file) !!}
                for(
                var i
            in
                files
            )
                {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document_file[]" value="' + file.file_name + '">')
                }
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@stop
