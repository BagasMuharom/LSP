<html lang="en">
<head>
    <title>APL 02 V2</title>
    @include('form.layouts.style')
    <style>
    section {
        page-break-after: always;
    }
    </style>
</head>
<body>
    <h1 class="fs-14">FR. APL-02. ASESMEN MANDIRI</h1>

    <table border="1" class="table-full table-pd-5 table-border">
        <tbody>
            <tr>
                <td colspan="4">PANDUAN ASESMEN MANDIRI</td>
            </tr>
            <tr>
                <td rowspan="2">Skema Sertifikasi/ Klaster Asesmen</td>
                <td>Judul</td>
                <td width="5%">:</td>
                <td width="60%">{{ $skema->nama }}</td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{ $skema->kode }}</td>
            </tr>
            <tr>
                <td colspan="2">TUK</td>
                <td>:</td>
                <td>Sewaktu<span style="text-decoration: line-through;">/Tempat Kerja/Mandiri</span>*</td>
            </tr>
            <tr>
                <td colspan="2">Nama Asesor</td>
                <td>:</td>
                <td>
                    <ol style="margin: 0;padding-left: 20px;">
                        @foreach ($uji->getAsesorUji(false) as $asesor)
                            <li>{{ $asesor->nama }}</li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            <tr>
                <td colspan="2">Nama Peserta</td>
                <td>:</td>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td colspan="2">Tanggal</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4">
                    Instruksi:
                    <ul>
                        <li>Baca setiap pertanyaan di kolom sebelah kiri</li>
                        <li>Beri tanda centang (<b class="unicode">&#10003;</b>) pada kotak jika Anda yakin dapat melakukan tugas yang dijelaskan.</li>
                        <li>Isi kolom di sebelah kanan dengan mendaftar bukti yang Anda miliki untuk menunjukkan bahwa Anda melakukan tugas-tugas ini.</li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    
    @foreach($skema->getSkemaUnit(false) as $unit)

    <br>

    <section>
    <table border="1" class="table-full table-pd-5 table-border">
        <tr>
            <td width="25%">Unit Kompetensi</td>
            <td>
                {{ $unit->kode }}<br>
                {{ $unit->nama }}
            </td>
        </tr>
    </table>
    <table border="1" class="table-full table-pd-5 table-border" style="margin-top: -2px">
        <tbody>
            <tr>
                <td class="center">Dapatkah Saya ?</td>
                <td class="center">K</td>
                <td class="center">BK</td>
                <td class="center">Bukti</td>
            </tr>
            
            @foreach ($unit->getElemenKompetensi(false) as $elemen)
            <tr>
                <td colspan="4">
                    {{ $loop->iteration }}. Elemen : {{ $elemen->nama }} ?
                </td>
            </tr>

            @foreach ($elemen->getKriteria(false) as $kriteria)
            @php 
            $nilai = $uji->getPenilaianDiri()->where('id', $kriteria->id)->first();
            @endphp
            <tr>
                <td width="60%">{{ $kriteria->kalimat_aktif }}</td>
                <td class="center">
                    <b class="unicode">{!! $nilai->pivot->nilai == \App\Support\Penilaian::KOMPETEN ? '&#10003;' : '' !!}</b>
                </td>
                <td class="center">
                    <b class="unicode">{!! $nilai->pivot->nilai == \App\Support\Penilaian::BELUM_KOMPETEN ? '&#10003;' : '' !!}</b>
                </td>
                <td width="25%">
                    {{ $nilai->pivot->bukti }}
                </td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
    </section>
    @endforeach

    <table border="1" class="table-full table-pd-5 table-border">
        <tbody>
            <tr>
                <td style="width: 33.33%">
                    Nama Asesi :<br>
                    {{ $mahasiswa->nama }}
                </td>
                <td style="width: 33.33%">
                    Tanggal : <br>
                    {{ formatDate(\Carbon\Carbon::parse($uji->tanggal_uji), false, false) }}<br>
                </td>
                <td style="width: 33.33%">
                    Tanda Tangan Asesi : <br>
                    @if($mahasiswa->getTTD(false)->count() > 0)
                    <img width="150" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}" class="img-responsive">
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="table-full table-pd-5 table-border" style="margin-top: -3px">
        <tbody>
            <tr>
                <td colspan="3">Ditinjau oleh Pelatih dan / atau Asesor</td>
            </tr>
            <tr>
                <td style="width: 33.33%">
                    <b>Nama Pelatih dan / atau Asesor :</b><br>
                    <ol style="margin: 0;padding-left: 20px;">
                        @foreach ($uji->getAsesorUji(false) as $asesor)
                            <li>{{ $asesor->nama }}</li>
                        @endforeach
                    </ol>
                </td>
                <td style="width: 33.33%">
                    <b>Rekomendasi :</b> <br>
                    {{ $uji->rekomendasi_asesor_asesmen_diri }}
                </td>
                <td style="width: 33.33%">
                    <b>Tanda Tangan dan Tanggal :</b><br>
                    @foreach ($uji->getAsesorUji(false) as $asesor)
                        @if($asesor->getTTD(false)->count() > 0)
                        <img width="150" src="{{ $asesor->getTTD(false)->random()->ttd }}">
                        <br>
                        {{ formatDate(\Carbon\Carbon::parse($uji->tanggal_uji), false, false) }}
                        @endif
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>