<html>
    <head>
        <title>MAK 05</title>

        @include('form.layouts.style')
    </head>

    <body>
        <h1 class="fs-14">FR-MAK-05. FORMULIR LAPORAN ASESMEN</h1>
        <br>
        <table class="table-full table-pd-5 table-border" border="1">
            <tbody>
            <tr>
                <td rowspan="2" style="width: 25%">
                    Skema Sertifikasi/<br> Klaster Asesmen
                </td>
                <td style="width: 10%">
                    Judul
                </td>
                <td style="width: 1%">:</td>
                <td>{{ $skema->nama }}</td>
            </tr>
            
            <tr>
                <td style="width: 10%">
                    Nomor
                </td>
                <td style="width: 1%">:</td>
                <td>{{ $skema->kode }}</td>
            </tr>

            <tr>
                <td colspan="2">TUK</td>
                <td style="width: 1%">:</td>
                <td>Sewaktu/<del>Tempat Kerja/Mandiri</del>*</td>
            </tr>
            
            <tr>
                <td colspan="2">Nama Asesor</td>
                <td style="width: 1%">:</td>
                <td>
                    <ol style="margin: 0;padding-left: 20px;">
                        @foreach ($daftarUji->first()->getAsesorUji(false) as $asesor)
                            <li>{{ $asesor->nama }}</li>
                        @endforeach
                    </ol>
                </td>
            </tr>
                <tr>
                    <td colspan="2">Tanggal</td>
                    <td>:</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <span class="fs-11">* Coret yang tidak perlu</span><br>

        <table class="table-full table-pd-5 table-border" border="1">
            <thead>
                <tr class="bg-biru">
                    <th>No.</th>
                    <th>Nama Peserta</th>
                    <th>K</th>
                    <th>BK</th>
                    <th>Keterangan**</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarUji as $uji)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $uji->getMahasiswa(false)->nama }}</td>
                        <td style="text-align: center">
                        <b class="unicode">{!! $uji->isLulus()  ? '&#10003;' : '' !!}</b>
                        </td>
                        <td style="text-align: center">
                        <b class="unicode">{!! !$uji->isLulus() ? '&#10003;' : '' !!}</b>
                        </td>
                        <td>
                            @if(!$uji->isLulus())
                                @foreach ($uji->getUnitYangBelumKompeten(false) as $unit)
                                    {{ $unit->nama }} ({{ $unit->kode }})<br>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <span class="fas-12">** tuliskan Kode dan Judul Unit Kompetensi yang dinyatakan BK      </span><br>

        <table class="table-full table-pd-5 table-border" border="1">
            <thead>
                <tr>
                    <th class="text-center bg-biru">Aspek Negatif dan Positif Dalam asesemen</th>
                    <th class="text-center bg-biru">Pencatatan Penolakan Hasil Asesmen</th>
                    <th class="text-center bg-biru">Saran Perbaikan : <br/>(Asesor/Personil Terkait)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">Asesmen berjalan lancar</td>
                    <td class="text-center">Tidak ada</td>
                    <td class="text-center" style="font-size: 20pt"><b>-</b></td>
                </tr>
            </tbody>
        </table>

        <br>

        <table class="table-full table-pd-5 table-border" border="1">
            <tr>
                <td width="50%" class="text-bold" colspan="2">Penanggung Jawab Pelaksanaan Asesmen :</td>
                <td class="text-bold" colspan="2">Asesor : </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $ketua->nama }}</td>
                <td>Nama</td>
                <td>{{ $daftarUji->first()->getAsesorUji()->first()->nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>Ketua LSP Unesa</td>
                <td>No. Reg.</td>
                <td>{{ $daftarAsesorUji->first()->nip }}</td>
            </tr>
            <tr>
                <td rowspan="{{ ($daftarAsesorUji->count() - 1) * 3 + 1 }}">Tanda tangan/<br>Tanggal</td>
                <td rowspan="{{ ($daftarAsesorUji->count() - 1) * 3 + 1 }}">
                    <img style="width: 120px" src="{{ $ketua->getTTD(false)->random()->ttd }}">
                </td>
                <td>Tanda tangan/<br>Tanggal</td>
                <td>
                    @if($daftarAsesorUji->first()->getTTD(false)->count() > 0)
                    <img style="width: 120px" src="{{ $daftarAsesorUji->first()->getTTD(false)->random()->ttd }}">
                    <br><br>
                    @endif
                </td>
            </tr>

            @foreach($daftarAsesorUji as $asesor)
                @if($loop->iteration == 1)
                    @continue
                @endif

                <tr>
                    <td>Nama</td>
                    <td>{{ $asesor->nama }}</td>
                </tr>

                <tr>
                    <td>No. Reg</td>
                    <td>{{ $asesor->nip }}</td>
                </tr>

                <tr>
                    <td>Tanda tangan/<br>Tanggal</td>
                    <td>
                        @if($asesor->getTTD(false)->count() > 0)
                        <img style="width: 120px" src="{{ $asesor->getTTD(false)->random()->ttd }}"><br><br>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </body>
</html>