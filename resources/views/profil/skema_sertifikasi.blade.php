@extends('layouts.profile.app')

@section('title', 'Skema Sertifikasi | '.kustomisasi('nama'))

@section('content')

<ul class="breadcrumb">
    <li>
        <a href="{{ url('/') }}">Beranda</a>
    </li>
    <li class="active">Skema Sertifikasi</li>
</ul>

<h1>Skema Sertifikasi</h1>

<table class="table table-bordered table-hovered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Skema</th>
            <th>Nama Skema</th>
            <th>Biaya Registrasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach (App\Models\Skema::all() as $skema)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $skema->kode }}</td>
                <td>{{ $skema->nama }}</td>
                <td class="text-right">Rp {{ number_format($skema->harga, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('profil.skema.sertifikasi.detail', ['skema' => $skema->id]) }}" class="btn btn-primary">Lihat Detail</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection