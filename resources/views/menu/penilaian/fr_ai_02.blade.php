@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Mengisi Form Uji Observasi| LSP Unesa')

@push('css')
<style>
    .table thead th {
        vertical-align: middle;
        text-align: center
    }
</style>
@endpush

@section('content')

    @include('layouts.include.alert')

    @card
        <h5>Anda akan mengisi isian Form FR AI 02 (Uji Observasi) untuk mahasiswa berikut : </h5>
        <p>
            Nama&emsp; : {{ $mahasiswa->nama }}<br>
            Skema&emsp;: {{ $skema->nama }}
        </p>
    @endcard

    <form id="form" action="{{ route('uji.isi.fr_ai_02', ['uji' => encrypt($uji->id)]) }}" method="post">
        @csrf

        @foreach($skema->getSkemaUnit(false) as $unit)
        @card
            @slot('title', 'Unit : ' . $unit->nama)

                @forelse($unit->getPertanyaanObservasi(false) as $pertanyaan)
                @php
                    $isi = (clone $isian)->wherePivot('pertanyaan_observasi_id', $pertanyaan->id)->first();
                    $jawaban = is_null($isi) ? '' : $isi->pivot->jawaban;
                    $memuaskan = is_null($isi) ? true : $isi->pivot->memuaskan;
                @endphp
                <div class="row">
                    <div class="col-lg-12">
                        <label><b>Pertanyaan : </b></label><br>
                        {{ $pertanyaan->pertanyaan }}

                        <br>

                        <label><b>Jawaban Asesi : </b></label>
                        <textarea class="form-control mb-3" name="isian[{{ $pertanyaan->id }}][jawaban]">{{ $jawaban }}</textarea>

                        <label>Apakah respon yang di dapat memuaskan ?</label>
                        @row
                            @col(['size' => 2])
                                <div class="custom-control custom-control-lg custom-radio mb-3">
                                    <input type="radio" class="custom-control-input" id="respon_ya_{{ $pertanyaan->id }}" name="isian[{{ $pertanyaan->id }}][memuaskan]" value="Ya" {{ $memuaskan ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="respon_ya_{{ $pertanyaan->id }}">Ya</label>
                                </div>
                            @endcol
                            @col(['size' => 2])
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input type="radio" class="custom-control-input" id="respon_tidak_{{ $pertanyaan->id }}" name="isian[{{ $pertanyaan->id }}][memuaskan]" value="Tidak" {{ !$memuaskan ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="respon_tidak_{{ $pertanyaan->id }}">Tidak</label>
                                </div>
                            @endcol
                        @endrow
                        
                    </div>
                </div>
                @empty
                    <p class="alert alert-warning">Tidak ada pertanyaan pada unit ini</p>
                @endforelse
        @endcard
        @endforeach

        @card
        <p class="alert alert-info">
            Isian pada form diatas dapat diubah kembali selama penilaian belum di konfirmasi oleh asesor
        </p>
        <div class="d-flex justify-content-center">
            <button onclick="event.preventDefault();if(confirm('Apa anda yakin ?')) $('#form').submit()" class="btn btn-primary btn-lg mt-3">Kirim</button>
        </div>
        @endcard
    </form>
@endsection