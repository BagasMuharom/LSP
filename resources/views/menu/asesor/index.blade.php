@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Daftar Asesor | LSP Unesa')

@section('content')
@card
    @slot('title', 'Daftar Asesor')

    {{-- Filter --}}
    <form action="{{ url()->current() }}" method="get">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Pencarian</label>
                    <input type="text" name="keyword" class="form-control" placeholder="Ketik nama atau met" value="{{ request()->has('keyword') ? request('keyword') : '' }}">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button class="btn btn-primary" type="submit">Lakukan Filter</button>
                </div>
            </div>
        </div>    
    </form>

    @slot('table')
    <p class="pl-3">
        Jumlah data : <b>{{ $total }}</b> 
    </p>
    <table class="table">
        <thead>
            <tr>
                <th>MET</th>
                <th>Nama</th>
                <th>Jumlah Skema</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($daftarAsesor as $asesor)
                <tr>
                    <td>{{ $asesor->nip }}</td>
                    <td>{{ $asesor->nama }}</td>
                    <td>{{ $asesor->getAsesorSkema()->count() }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('asesor.edit', ['asesor' => encrypt($asesor->id)]) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pl-3">
        {{ $daftarAsesor->links() }}
    </div>
    @endslot
@endcard
@endsection