var uploadedDocumentMap = {}

Dropzone.options.documentFileDropzone = {
    url: upload_url,
    parallelUploads: 2,
    maxFilesize: 1, // MB
    maxFiles: 10,
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': token
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
        for (var i in drop_files) {
            var file = drop_files[i]
            this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="document_file[]" value="' + file.file_name + '">')
        }
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
