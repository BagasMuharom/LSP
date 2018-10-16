@extends('layouts.profile.app')

@section('title', 'Galeri | '.kustomisasi('nama'))

@section('content')

    <div class="row">
        @foreach ($daftarGaleri as $galeri)
        <div class="col-lg-3 margin-bottom-20" style="height: 300px;overflow: hidden">
            <div class="card">
                <a href="{{ route('profil.galeri.detail', ['idgaleri' => $galeri->id]) }}"><img class="card-img-top" src="{{ asset($galeri->getFoto()->first()->dir) }}" alt="Card image cap" style="width: 100%;height: 150px"></a>
                <div class="card-body" style="padding: 10px">
                    <h4 class="card-title"><a href="{{ route('profil.galeri.detail', ['idgaleri' => $galeri->id]) }}">{{ $galeri->nama }}</a></h4>
                    <p class="card-text">{{ $galeri->keterangan }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endsection