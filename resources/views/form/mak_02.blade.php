<html lang="en">
<head>
    <title>MAK 02</title>
    @include('form.layouts.style')
</head>
<body>
    <h1 class="fs-14">FR-MAK- 02. KEPUTUSAN DAN UMPAN BALIK ASESMEN</h1>

    <table class="table-full table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td rowspan="2">Skema Sertifikasi/ Klaster Asesmen</td>
                <td>Judul</td>
                <td>:</td>
                <td>{{ $skema->nama }}</td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{ $skema->kode }}</td>
            </tr>
            <tr>
                <td colspan="2">TUK</td>
                <td>:</td>
                <td>Sewaktu/Tempat Kerja/Mandiri*</td>
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
                <td>{{ $uji->getMahasiswa(false)->nama }}</td>
            </tr>
            <tr>
                <td colspan="2">Tanggal</td>
                <td>:</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <span class="fs-11">* coret yang dianggap tidak perlu</span>

    <p class="fs-12 text-justify">
        <b>Asesor diminta untuk :</b>
        <ol>
            <li class="text-justify">Mengkaji ulang dan menilai bukti kompetensi peserta yang dikumpulkan, apakah bukti kompetensi tersebut memenuhi aturan bukti Valid, Asli, Terkini dan Memadai (VATM).</li>
            <li class="text-justify">Membuat keputusan Asesmen atas penilaian bukti kompetensi Peserta, bila Peserta dinyatakan Kompeten tuliskan tanda <b class="unicode">&#10003;</b> pada kolom (K), dan bila dinyatakan Belum Kompeten tuliskan tanda <b class="unicode">&#10003;</b> pada kolom (BK) untuk setiap unit kompetensi sesuai dengan skema sertifikasi.</li>
            <li class="text-justify">Memberikan umpan balik kepada Peserta mengenai pencapaian unjuk kerja dan Peserta juga diminta untuk memberikan umpan balik terhadap proses asesmen yang dilaksanakan (kuesioner). </li>
            <li class="text-justify">Asesor dan Peserta bersama-sama menandatangani keputusan asesmen.</li>
        </ol>
    </p>
    
    <b>Pencapaian Kompetensi :</b>

    <table class="table-full table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td rowspan="2">No</td>
                <td rowspan="2">Unit Kompetensi</td>
                <td rowspan="2">Bukti-bukti</td>
                <td rowspan="2">Jenis Bukti</td>
                <td colspan="2">Pencapaian</td>
                <td colspan="2">Keputusan</td>
            </tr>
            <tr>
                <td>Ya</td>
                <td>Tidak</td>
                <td>K</td>
                <td>BK</td>
            </tr>
            @foreach($skema->getSkemaUnit(false) as $unit)
                <tr>
                    <td rowspan="{{ count($uji->getBuktiUnitTertentu($unit)) + 1 }}">{{ $loop->iteration }}</td>
                    <td rowspan="{{ count($uji->getBuktiUnitTertentu($unit)) + 1 }}">
                        {{ $unit->kode }} dan {{ $unit->nama }}
                    </td>
                    <td>Rekaman hasil observasi</td>
                    <td>L</td>
                    <td>
                        <b class="unicode">{!! !in_array($unit->id, $uji->getUnitYangBelumKompeten(false)->pluck('id')->toArray()) ? '&#10003;' : '' !!}</b>
                    </td>
                    <td>
                        <b class="unicode">{!! in_array($unit->id, $uji->getUnitYangBelumKompeten(false)->pluck('id')->toArray()) ? '&#10003;' : '' !!}</b>
                    </td>
                    <td rowspan="{{ count($uji->getBuktiUnitTertentu($unit)) + 1 }}">
                        <b class="unicode">{!! !in_array($unit->id, $uji->getUnitYangBelumLulus(false)->pluck('id')->toArray()) ? '&#10003;' : '' !!}</b>
                    </td>
                    <td rowspan="{{ count($uji->getBuktiUnitTertentu($unit)) + 1 }}">
                        <b class="unicode">{!! in_array($unit->id, $uji->getUnitYangBelumLulus(false)->pluck('id')->toArray()) ? '&#10003;' : '' !!}</b>
                    </td>
                </tr>
                @foreach ($uji->getBuktiUnitTertentu($unit) as $bukti => $nilai)
                    <tr>
                        <td>Rekaman hasil {{ $bukti }}</td>
                        <td>T</td>
                        <td><b class="unicode">{!! $nilai === 'K' ? '&#10003;' : '' !!}</b></td>
                        <td><b class="unicode">{!! $nilai === 'BK' ? '&#10003;' : '' !!}</b></td>
                    </tr>
                @endforeach
                
            @endforeach
        </tbody>
    </table>
    <br>
    <table class="table-full table-border table-pd-5" border="1">
        <tr>
            <td>
                <b>Umpan balik terhadap pencapaian unjuk kerja :</b><br>
                {!! $uji->umpan_balik !!}
            </td>
        </tr>
        
        <tr>
            <td>
                <b>Identifikasi kesenjangan pencapaian unjuk kerja :</b><br>
                {!! $uji->identifikasi_kesenjangan !!}
            </td>
        </tr>
        
        <tr>
            <td>
                <b>Saran tindak lanjut hasil asesmen  :</b><br>
                {!! $uji->saran_tindak_lanjut !!}
            </td>
        </tr>
        <tr></tr>
    </table>

    <table class="table-full table-pd-5 table-border" border="1" style="page-break-inside: avoid">
            <tr>
                <td width="40%" rowspan="{{ (($uji->getAsesorUji()->count() * 3) + 5) }}">
                    <b>Rekomendasi Asesor :</b><br>
                    Peserta direkomendasikan <b>{!! $uji->isLulus() ? 'Kompeten' : '<del>Kompeten</del>' !!}/{!! !$uji->isLulus() ? 'Belum Kompeten' : '<del>Belum Kompeten</del>' !!} *)</b> pada <b>Skema sertifikasi/Klaster Asesmen *)</b> yang diujikan ({{ $uji->getSkema(false)->nama }})
                </td>
                <td colspan="2" class="text-center"><b>Asesor</b></td>
            </tr>
            @foreach($uji->getAsesorUji(false) as $asesor)
                <tr>
                    <td>Nama</td>
                    <td><b>{{ $asesor->nama }}</b></td>
                </tr>
                <tr>
                    <td>No. Reg</td>
                    <td><b>{{ $asesor->nip }}</b></td>
                </tr>
                <tr>
                    <td>Tanda Tangan & Tanggal</td>
                    <td>
                        @if($asesor->getTTD(false)->count() > 0)
                        <img width="200" src="{{ $asesor->getTTD(false)->random()->ttd }}">
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="bold">Peserta</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><b>{{ $uji->getMahasiswa(false)->nama }}</b></td>
            </tr>
            <tr>
                <td>No. Reg.</td>
                <td><b>{{ $uji->nim }}</b></td>
            </tr>
            <tr>
                <td>Tanda Tangan & Tanggal</td>
                <td class="text-center">
                    @if($uji->getMahasiswa(false)->getTTD(false)->count() > 0)
                    <img width="200" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}" class="img-responsive">
                    @endif
                    {{-- {{ formatDate($uji->updated_at) }} --}}
                </td>
            </tr>
        </table>
</body>
</html>