<html lang="en">
<head>
    <title>FR AI 01</title>
    @include('form.layouts.style')
    <style>
        .bg-green {
            background-color: rgb(197, 224, 179);
        }
    </style>
</head>
<body>
    <h1 class="fs-14">FR. AI.01. CEKLIS OBSERVASI UNTUK AKTIVITAS DI TEMPAT KERJA ATAU TEMPAT KERJA SIMULASI</h1>

    <table class="table-full table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td class="bg-green">Nama Asesi</td>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td class="bg-green">Nama Asesor</td>
                <td>
                    <ol style="margin: 0;padding-left: 20px;">
                        @foreach ($uji->getAsesorUji(false) as $asesor)
                            <li>{{ $asesor->nama }}</li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            <tr>
                <td class="bg-green">Skema</td>
                <td>{{ $skema->nama }}</td>
            </tr>
            <tr>
                <td class="bg-green">Tempat Uji Kompetensi</td>
                <td></td>
            </tr>
            <tr>
                <td class="bg-green">Tanggal Asesmen</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    @foreach($skema->getSkemaUnit(false) as $unit)

    <table border="1" class="table-full table-pd-5 table-border">
        <tr>
            <td width="25%">Unit Kompetensi</td>
            <td>
                {{ $unit->kode }}<br>
                {{ $unit->nama }}
            </td>
        </tr>
    </table>

    <table border="1" class="table-full table-pd-5 table-border">
        <tbody>
            <tr>
                <td>No.</td>
                <td>Elemen</td>
                <td>Kriteria Unjuk Kerja</td>
                <td>Benchmark <br> (SOP / Spesifikasi Produk Industri)</td>
                <td>K</td>
                <td>BK</td>
                <td>Penilaian Lanjut</td>
            </tr>
        @foreach($unit->getElemenKompetensi(false) as $elemen)
            <tr>
                <td rowspan="{{ $elemen->getKriteria()->count() }}">{{ $loop->iteration }}</td>
                <td rowspan="{{ $elemen->getKriteria()->count() }}">{{ $elemen->nama }}</td>
                <td>{{ $elemen->getKriteria()->first()->kalimat_aktif }}</td>
                <td rowspan="{{ $elemen->getKriteria()->count() }}">{{ $elemen->benchmark }}</td>
                <td>
                    @if ($uji->getPenilaian()->where('id', $elemen->getKriteria()->first()->id)->first()->pivot->nilai == App\Support\Penilaian::KOMPETEN)
                        <b class="unicode">&#10003;</b>
                    @endif
                </td>
                <td>
                    @if ($uji->getPenilaian()->where('id', $elemen->getKriteria()->first()->id)->first()->pivot->nilai == App\Support\Penilaian::BELUM_KOMPETEN)
                        <b class="unicode">&#10003;</b>
                    @endif
                </td>
                <td></td>
            </tr>

            @foreach ($elemen->getKriteria()->afterFirst(false) as $kriteria)
            <tr>
                <td>{{ $kriteria->kalimat_aktif }}</td>
                <td>
                    @if ($uji->getPenilaian()->where('id', $elemen->getKriteria()->first()->id)->first()->pivot->nilai == App\Support\Penilaian::KOMPETEN)
                        <b class="unicode">&#10003;</b>
                    @endif
                </td>
                <td>
                    @if ($uji->getPenilaian()->where('id', $elemen->getKriteria()->first()->id)->first()->pivot->nilai == App\Support\Penilaian::BELUM_KOMPETEN)
                        <b class="unicode">&#10003;</b>
                    @endif
                </td>
                <td></td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
    @endforeach

    <table class="table-full table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td class="bg-green">Pengetahuan kandidat adalah</td>
                <td>
                    <b class="unicode">{!! $uji->isLulus() ? '&#10003;' : '' !!}</b> Memuaskan
                </td>
                <td>
                    <b class="unicode">{!! !$uji->isLulus() ? '&#10003;' : '' !!}</b> Tidak Memuaskan
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <b>Umpan balik untuk kandidat : </b><br>
                    {!! $uji->umpan_balik !!}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table-full table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td class="bg-green">Tanda Tangan Asesi : </td>
                <td>
                    @if($uji->getMahasiswa(false)->getTTD(false)->count() > 0)
                    <img width="200" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}" class="img-responsive">
                    <br>
                    {{ formatDate($uji->tanggal_uji, false, false) }}
                    @endif
                </td>
            </tr>
            @foreach($uji->getAsesorUji(false) as $asesor)
            <tr>
                <td class="bg-green">Tanda Tangan Asesor {{ $loop->iteration }} : </td>
                <td>
                    @if($asesor->getTTD(false)->count() > 0)
                    <img width="200" src="{{ $asesor->getTTD(false)->random()->ttd }}">
                    <br>
                    {{ formatDate($uji->tanggal_uji, false, false) }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>