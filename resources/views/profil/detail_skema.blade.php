@extends('layouts.profile.app') 

@section('title', $skema->nama.' | '.kustomisasi('nama'))

@section('content')
<ul class="breadcrumb">
    <li>
        <a href="{{ url('/') }}">Beranda</a>
    </li>
    <li>
        <a href="{{ route('profil.skema.sertifikasi') }}">Skema Sertifikasi</a>
    </li>
    <li class="active">{{ $skema->nama }}</li>
</ul>

<h1>Skema {{ $skema->nama }}</h1>
<p>Berikut adalah daftar unit dari skema {{ $skema->nama }}.</p>
<table class="table table-bordered table-hovered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Unit</th>
            <th>Kode Unit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($skema->getSkemaUnit(false) as $unit)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $unit->nama }}</td>
            <td>{{ $unit->kode }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p>Berikut adalah daftar persyaratan dari skema {{ $skema->nama }}</p>
<table class="table table-bordered table-hovered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Syarat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($skema->getSyarat(false) as $syarat)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $syarat->nama }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection