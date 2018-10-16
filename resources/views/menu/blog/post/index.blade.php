@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <a class="btn btn-success text-white" href="{{ route('blog.tambah') }}">Buat Post</a>
    @card
    @slot('title', 'Daftar Pos')

    @alert(['type' => 'info'])
    Terdapat {{ $data->total() }} sesuai filter
    @endalert

    <form action="{{ url()->current() }}">
        <div class="input-group">
            <input type="text" id="input-group-2" name="q" class="form-control"
                   placeholder="Cari berdasarkan judul, permalink, isi atau penulis" value="{{ $q }}">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Cari
                </button>
            </span>
        </div>
    </form>

    @slot('table')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Dibuat</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $post)
            <tr>
                <th>{{ ($data->currentpage() * $data->perpage()) + (++$no) - $data->perpage()  }}</th>
                <th>{{ $post->judul }}</th>
                <th>{{ $post->getPenulis(false)->nama }}</th>
                <th>{{ formatDate($post->created_at) }}</th>
                <th>
                    <div class="btn-group">
                        <a class="btn btn-warning btn-sm text-white" href="{{ route('blog.detail', ['post' => encrypt($post->id)]) }}">Detail/Edit</a>
                        <a class="btn btn-danger btn-sm text-white" href="{{ route('blog.delete', ['post' => encrypt($post->id)]) }}">Hapus</a>
                    </div>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
    @endslot
    @endcard
@endsection