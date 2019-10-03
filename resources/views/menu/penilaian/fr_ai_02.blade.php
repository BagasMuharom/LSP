@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Mengisi Form AI 02 | LSP Unesa')

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
        <h5>Anda akan mengisi isian Form FR AI 02 untuk mahasiswa berikut : </h5>
        <p>
            Nama&emsp; : {{ $mahasiswa->nama }}<br>
            Skema&emsp;: {{ $skema->nama }}
        </p>
    @endcard

    @card
        @slot('title', 'Tambah Pertanyaan dan Respon')

        <form id="form" action="{{ route('uji.tambah.respon.fr_ai_02', ['uji' => encrypt($uji->id)]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <label>Pertanyaan : </label>
                    <textarea class="form-control mb-3" name="pertanyaan"></textarea>

                    <label>Jawaban Asesi : </label>
                    <textarea class="form-control mb-3" name="jawaban"></textarea>
                </div>

                <div class="col-lg-4">
                    <label>Unit : </label>
                    <select name="unit" class="custom-select mb-3">
                        @foreach ($skema->getSkemaUnit(false) as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                        @endforeach
                    </select>

                    <label>Apakah respon yang di dapat memuaskan ?</label>
                    <div class="custom-control custom-control-lg custom-radio mb-3">
                        <input type="radio" class="custom-control-input" id="respon_ya" name="memuaskan" value="Ya" checked>
                        <label class="custom-control-label" for="respon_ya">Ya</label>
                    </div>
                    
                    <div class="custom-control custom-control-lg custom-radio">
                        <input type="radio" class="custom-control-input" id="respon_tidak" name="memuaskan" value="Tidak">
                        <label class="custom-control-label" for="respon_tidak">Tidak</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button onclick="event.preventDefault();if(confirm('Apa anda yakin ?')) $('#form').submit()" class="btn btn-primary btn-lg mt-3">Kirim</button>
            </div>

        </form>
    @endcard
    
    @card
        @slot('title', 'Edit Pertanyaan dan Respon Sebelumnya')

        <form id="form-edit" action="{{ route('uji.edit.respon.fr_ai_02', ['uji' => encrypt($uji->id)]) }}" method="post">
            @csrf

            @forelse($daftarRespon['hasil'] as $respon)

            <div class="row">
                <div class="col-lg-8">
                    <label>Pertanyaan : </label>
                    <textarea class="form-control mb-3" name="respon[{{ $loop->iteration }}][pertanyaan]">{{ $respon['pertanyaan'] }}</textarea>

                    <label>Jawaban Asesi : </label>
                    <textarea class="form-control mb-3" name="respon[{{ $loop->iteration }}][jawaban]">{{ $respon['jawaban'] }}</textarea>
                </div>

                <div class="col-lg-4">
                    <label>Unit : </label>
                    <select name="respon[{{ $loop->iteration }}][unit]" class="custom-select mb-3">
                        @foreach ($skema->getSkemaUnit(false) as $unit)
                            <option value="{{ $unit->id }}" {{ $unit->id == $respon['unit']->id ? 'selected' : '' }}>{{ $unit->nama }}</option>
                        @endforeach
                    </select>

                    <label>Apakah respon yang di dapat memuaskan ?</label>
                    <div class="custom-control custom-control-lg custom-radio mb-3">
                        <input type="radio" class="custom-control-input" id="respon_ya{{ $loop->iteration }}" name="respon[{{ $loop->iteration }}][memuaskan]" value="Ya" {{ $respon['memuaskan'] == 'Ya' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="respon_ya{{ $loop->iteration }}">Ya</label>
                    </div>
                    
                    <div class="custom-control custom-control-lg custom-radio">
                        <input type="radio" class="custom-control-input" id="respon_tidak{{ $loop->iteration }}" name="respon[{{ $loop->iteration }}][memuaskan]" value="Tidak" {{ $respon['memuaskan'] == 'Tidak' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="respon_tidak{{ $loop->iteration }}">Tidak</label>
                    </div>
                </div>
            </div>

            <hr style="border-color: #aaa">

            @empty

            <p class="alert alert-primary">Belum ada respon yang ditambahkan.</p>

            @endforelse

            @if(count($daftarRespon['hasil']) > 0)

            <label>Pengetahuan kandiddat adalah :</label>
            <div class="custom-control custom-control-lg custom-radio mb-3">
                <input type="radio" class="custom-control-input" id="pengetahuan_kandidat_memuaskan" name="pengetahuan_kandidat" value="Memuaskan" {{ isset($daftarRespon['umum']) && $daftarRespon['umum']['pengetahuan_kandidat'] == 'Memuaskan' ? 'checked' : '' }}>
                <label class="custom-control-label" for="pengetahuan_kandidat_memuaskan">Memuaskan</label>
            </div>
            
            <div class="custom-control custom-control-lg custom-radio">
                <input type="radio" class="custom-control-input" id="pengetahuan_kandidat_tidak_memuaskan" name="pengetahuan_kandidat" value="Tidak Memuaskan" {{ isset($daftarRespon['umum']) && $daftarRespon['umum']['pengetahuan_kandidat'] == 'Tidak Memuaskan' ? 'checked' : '' }}>
                <label class="custom-control-label" for="pengetahuan_kandidat_tidak_memuaskan">Tidak Memuaskan</label>
            </div>

            <hr style="border-color: #aaa">

            <div class="d-flex justify-content-center">
                <button onclick="event.preventDefault();if(confirm('Apa anda yakin ?')) $('#form-edit').submit()" class="btn btn-primary btn-lg mt-3">Simpan</button>
            </div>
            @endif

        </form>
    @endcard
@endsection