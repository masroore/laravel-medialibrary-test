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
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentFileDropzone = {
            url: '{{ route('reply.upload') }}',
            maxFilesize: 2, // MB
            maxFiles: 10,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
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
                for (var i in files) {
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

