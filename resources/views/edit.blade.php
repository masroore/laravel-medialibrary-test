@extends('app')
@section('content')

    <div class="container">
        <table class="table table-borderless table-responsive">
            <tbody>
            @foreach($reply->attachments as $media)
                <tr id="media_{{ $media->id }}">
                    <td>
                        <a href="{{ $media->url }}" target="_blank"><img src="{{ $media->preview }}" alt=""></a>
                    </td>
                <!--
                    <td>
                        <form action="{{ route('media.destroy', $media->uuid) }}" method="POST"
                              onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                            @csrf
                @method('DELETE')
                    <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                </form>
            </td>
-->

                    <td>
                        <a href="javascript:void(0)"
                           data-elem="{{ $media->id }}"
                           data-id="{{ $media->uuid }}"
                           data-token="{{ csrf_token() }}"
                           class="btn btn-danger delete-media">Delete</a>
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
    @include('_script-setup')
    <script src="{{ asset('js/media-delete.js') }}"></script>
    <script src="{{ asset('js/dropz.js') }}"></script>
@stop
