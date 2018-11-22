@extends('layouts.profile.app')

@section('title', 'Kontak | '.kustomisasi('nama'))

@section('content')
<h1>Kontak Kami</h1>
<ul class="breadcrumb">
    <li>
        <a href="{{ url('/') }}">Beranda</a>
    </li>
    <li class="active">Kontak</li>
</ul>

<div class="row margin-bottom-40">
    <div class="col-lg-4">
        <img style="width: 70%;margin 0 auto" src="{{ asset(kustomisasi('logo')) }}" alt="Logo">
        <hr>
        <p>{{ kustomisasi('alamat') }}</p>
        <p>{{ kustomisasi('no_telepon') }}</p>
        <p>{{ kustomisasi('email') }}</p>
    </div>
    <div class="col-lg-8">
        <a href="https://www.google.com/maps/place/LSP+UNESA/@-7.3155747,112.7260221,18z/data=!4m5!3m4!1s0x2dd7fb7dda22e8eb:0xad67bceb68fc1c43!8m2!3d-7.315729!4d112.7270038"><img width="100%" src="{{ asset('img/lokasi.png') }}"></a>
    </div>
</div>
@endsection