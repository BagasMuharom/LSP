@extends('layouts.profile.app')

@section('title', 'Pengumuman | '.kustomisasi('nama'))

@section('content')
    <ul class="breadcrumb">
        <li>
            <a href="{{ url('/') }}">Beranda</a>
        </li>
        <li class="active">Pengumuman</li>
    </ul>

    <h1>Pengumuman</h1>

    <div class="alert alert-warning">
        {!! kustomisasi('pengumuman') !!}
    </div>
@endsection