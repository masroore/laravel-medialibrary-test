<script>
    let upload_url = '{{ route('reply.upload') }}';
    let media_url = '{{ url('media') }}/';
    let token = '{{ csrf_token() }}';
    @if(isset($reply) && $reply->document_file)
    let drop_files = {!! json_encode($reply->document_file) !!};
    @endif
</script>
