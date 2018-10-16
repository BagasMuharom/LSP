@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' > Foto | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @alert(['type' => 'info'])
    Terdapat {{ $galeri->getFoto()->count() ?? '-' }} foto pada galeri <b>{{ $galeri->nama ?? '-' }}</b>
    <br><br>
    {{ $galeri->keterangan ?? '-' }}
    <br><br>
    dibuat pada <b>{{ formatDate($galeri->created_at) ?? '-' }}</b>
    <br>
    diperbarui pada <b>{{ formatDate($galeri->updated_at) ?? '-' }}</b> oleh <b>{{ $galeri->getUser(false)->nama ?? '-' }}</b>
    @endalert

    @row
    @foreach($data as $foto)
        <div class="col-6">
            <div class="card">
                <a href="{{ asset($foto->dir) }}">
                    <img class="card-img-top" src="{{ asset($foto->dir) }}" alt="Card image cap">
                </a>
                <button class="btn btn-danger btn-sm btn-block" onclick="event.preventDefault(); $('#id').val('{{ encrypt($foto->id) }}'); $('#delete').submit()">Hapus</button>
            </div>
        </div>
    @endforeach
    @endrow

    <form action="{{ route('galeri.delete.foto') }}" method="post" id="delete">
        @csrf
        {{ method_field('delete') }}
        <input type="hidden" name="id" id="id">
    </form>

    {{ $data->links() }}
@endsection