@extends('layouts.profile.app')

@section('title', 'Galeri | '.kustomisasi('nama'))

@push('css')
    <link rel="stylesheet" href="{{ asset('profile/pages/css/gallery.css') }}">
@endpush

@section('content')

<ul class="breadcrumb">
    <li>
        <a href="{{ route('profil.home') }}">Beranda</a>
    </li>
    <li>
        <a href="{{ route('profil.galeri') }}">Galeri</a>
    </li>
    <li class="active">{{ $galeri->nama }}</li>
</ul>
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12">
        <h1>{{ $galeri->nama }}</h1>
        <div class="content-page">
            <div class="row margin-bottom-40">
                @foreach ($daftarFoto as $foto)
                <div class="col-md-3 col-sm-4 gallery-item">
                    <a data-rel="fancybox-button" title="{{ $foto->keterangan }}" href="{{ asset($foto->dir) }}" class="fancybox-button">
                        <img alt="" src="{{ asset($foto->dir) }}" class="img-responsive">
                        <div class="zoomix">
                            <i class="fa fa-search"></i>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>

@endsection