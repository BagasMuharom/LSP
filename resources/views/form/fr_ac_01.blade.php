<!doctype html>
<html lang="en">
<head>
    <style>
        .border tr td {
            border: 1px solid black;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .unicode {
            font-family: DejaVu Sans;
        }
    </style>
</head>
<body>
<h3><b>FR.AC.01. Formulir Rekaman Asesmen Kompetensi</b></h3>
<table class="table border">
    <tr>
        <td>
            Nama Asesi
        </td>
        <td>
            {{ $asesi->nama }}
        </td>
    </tr>
    <tr>
        <td>
            Nama asesor
        </td>
        <td>
            @foreach($asesors as $asesor)
                {{ $loop->iteration }}. {{ $asesor->nama }}<br>
            @endforeach
        </td>
    </tr>
    <tr>
        <td>
            Skema sertifikasi/ Standar/ Perangkat ketrampilan/ Okupasi/ Kualifikasi/ Klaster
        </td>
        <td>
            {{ $skema->getJenis(false)->nama }}
        </td>
    </tr>
    <tr>
        <td>
            Tanggal mulainya asesmen
        </td>
        <td>
            {{ formatDate($uji->tanggal_uji, false, false) }}
        </td>
    </tr>
    <tr>
        <td>
            Tanggal selesainya asesmen
        </td>
        <td>
            {{ formatDate($uji->tanggal_uji, false, false) }}
        </td>
    </tr>
    <tr>
        <td>
            Keputusan asesmen
        </td>
        <td>
            @if($uji->isLulus())
                Kompeten / <strike>Belum kompeten</strike>
            @else
                <strike>Kompeten</strike> / Belum kompeten
            @endif
        </td>
    </tr>
    <tr>
        <td>
            Tindak lanjut yang dibutuhkan
            (Masukkan pekerjaan tambahan dan asesmen yang diperlukan untuk mencapai kompetensi)
        </td>
        <td>
            {{ $uji->saran_tindak_lanjut }}
        </td>
    </tr>
    <tr>
        <td>Komentar/ Observasi oleh asesor </td>
        <td>{!! $uji->rekomendasi_asesor !!}</td>
    </tr>
</table>
<br>
<small class="unicode">Beri tanda centang (&#10003;) di kolom yang sesuai untuk mencerminkan bukti yang diperoleh untuk menentukan Kompetensi siswa untuk setiap Unit Kompetensi.</small>
<table class="table border">
    <tr>
        <td>Unit kompetensi</td>
        <td>Observasi demonstrasi</td>
        <td>Portofolio</td>
        <td>Pernyataan pihak ketiga</td>
        <td>Pertanyaan lisan</td>
        <td>Pertanyaan tertulis</td>
        <td>Proyek kerja</td>
        <td>Lainnya</td>
    </tr>
    @foreach($uji->helper['nilai_unit'] as $unit => $bukti)
        @php $unit = \App\Models\UnitKompetensi::query()->find($unit) @endphp
        <tr>
            <td>{{ $unit->kode.' '.$unit->nama }}</td>
            <td class="unicode">&#10003;</td>
            <td class="unicode">{!! (isset($bukti['Portofolio']) && !empty($bukti['Portofolio'])) ? '&#10003;' : '' !!}</td>
            <td class="unicode">{!! (isset($bukti['Verifikasi Pihak Ketiga']) && !empty($bukti['Verifikasi Pihak Ketiga'])) ? '&#10003;' : '' !!}</td>
            <td class="unicode">{!! (isset($bukti['Tes Lisan']) && !empty($bukti['Tes Lisan'])) ? '&#10003;' : '' !!}</td>
            <td class="unicode">{!! (isset($bukti['Tes Tertulis']) && !empty($bukti['Tes Tertulis'])) ? '&#10003;' : '' !!}</td>
            <td class="unicode">{!! (isset($bukti['Studi Kasus']) && !empty($bukti['Studi Kasus'])) ? '&#10003;' : '' !!}</td>
            <td></td>
        </tr>
    @endforeach
</table>
<table class="table border">
    <tbody>
    <tr>
        <td>Tanda Tangan Asesi : </td>
        <td>
            @if($uji->getMahasiswa(false)->getTTD(false)->count() > 0)
                <img width="200" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}" class="img-responsive">
            @endif
        </td>
        <td>Tanggal:</td>
        <td>{{ formatDate($uji->tanggal_uji, false, false) }}</td>
    </tr>
    @foreach($uji->getAsesorUji(false) as $asesor)
        <tr>
            <td>Tanda Tangan Asesor {{ $loop->iteration }} : </td>
            <td>
                @if($asesor->getTTD(false)->count() > 0)
                    <img width="200" src="{{ $asesor->getTTD(false)->random()->ttd }}">
                @endif
            </td>
            <td>Tanggal:</td>
            <td>{{ formatDate($uji->tanggal_uji, false, false) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<p>
LAMPIRAN: (dokumen elektronik)<br>
1. Dokumen APL 01 peserta<br>
2. Dokumen APL 02 peserta<br>
3. Bukti-bukti berkualitas peserta<br>
4. Tinjauan proses asesmen
</p>
</body>
</html>