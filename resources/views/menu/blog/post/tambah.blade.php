@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' > Buat | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @card
    @slot('title', 'Buat post baru')

    <form action="{{ route('blog.add') }}" method="post">
        @csrf
        {{ method_field('put') }}

        @formgroup
        <label>Judul</label>
        <input type="text" class="form-control" name="judul" required>
        @endformgroup

        @formgroup
        <label>Isi</label>
        <textarea name="isi"></textarea>
        @endformgroup

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>

    @endcard

    <iframe id="frameUpload" name="frameUpload" style="display:none"></iframe>
    <form id="formUpload" action="{{ route('blog.tinymce.upload') }}" target="frameUpload" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
        <input name="image" type="file" onchange="$('#formUpload').submit();this.value='';">
        {{ csrf_field() }}
    </form>
@endsection

@push('js')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script>
        $().ready(function () {
            tinymce.init({
                selector: 'textarea',
                entity_encoding : "raw",
                theme: 'modern',
                plugins: [
                    'image imagetools',
                    'autoresize'
                ],
                toolbar1: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                relative_urls: false,
                file_browser_callback: function(field_name, url, type, win) {
                    // trigger file upload form
                    if (type == 'image') $('#formUpload input').click();
                },
            });

        });
    </script>
@endpush