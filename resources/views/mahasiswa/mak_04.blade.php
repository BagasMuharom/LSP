@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Mengisi Form MAK 4 | LSP Unesa')

@push('css')
<style>
    .table thead th {
        vertical-align: middle;
        text-align: center
    }
</style>
@endpush

@section('content')
    @card
        @slot('title', 'Form Pengisian MAK 04')

        @slot('table')
        <form id="form" action="{{ route('uji.isi.mak4', ['uji' => encrypt($uji->id)]) }}" method="post">
        @csrf
        <table class="table table-border">
            <thead>
                <tr>
                    <th rowspan="2">Komponen</th>
                    <th colspan="2">Jawaban</th>
                    <th rowspan="2">Komentar</th>
                </tr>
                <tr>
                    <th>Ya</th>
                    <th>Tidak</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarKomponen as $komponen)
                    <tr>
                        <td>{{ $komponen->komponen }}</td>
                        <td>
                            <input type="radio" name="hasil[{{ $komponen->id }}][jawaban]" class="form-control" value="Ya" checked> Ya
                        </td>
                        <td>
                            <input type="radio" name="hasil[{{ $komponen->id }}][jawaban]" class="form-control" value="Tidak"> Tidak
                        </td>
                        <td>
                            <input type="text" name="hasil[{{ $komponen->id }}][komentar]" class="form-control">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-body">
            <label>Catatan/Komentar lainnya</label>
            <textarea name="catatan" class="form-control" placeholder="Tambahkan catatan lain..."></textarea>

            <p class="alert alert-warning mt-3">
                Anda tidak bisa mengubah setelah mengirim respon dari form MAK 04
            </p>

            <button onclick="event.preventDefault();if(confirm('Apa anda yakin ?')) $('#form').submit()" class="btn btn-primary btn-lg">Kirim</button>
        </div>

        </form>
        @endslot
    @endcard
@endsection