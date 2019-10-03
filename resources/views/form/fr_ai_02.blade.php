<html lang="en">
<head>
    <title>MAK 01</title>
    @include('form.layouts.style')
    <style>
        .bg-green {
            background-color: rgb(197, 224, 179);
        }
    </style>
</head>
<body>
    <h1 class="fs-14">FR. AI.02. PERTANYAAN UNTUK MENDUKUNG OBSERVASI</h1>

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

    @foreach($daftarResponPerUnit as $responPerUnit)

    <br>

    <table border="1" class="table-full table-pd-5 table-border">
        <tr>
            <td width="25%" rowspan="2">Unit Kompetensi No. {{ $loop->iteration }}</td>
            <td width="15%">Kode Unit</td>
            <td width="1%">:</td>
            <td>{{ $responPerUnit->first()['unit']->kode }}</td>
        </tr>
        <tr>
            <td>Judul Unit</td>
            <td>:</td>
            <td>{{ $responPerUnit->first()['unit']->nama }}</td>
        </tr>
    </table>

    <br>

    <table class="table-full table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td colspan="2" class="center middle">
                    Pertanyaan yang harus dijawab oleh kandidat
                </td>
                <td width="20%">
                    Respon yang memuaskan Ya atau Tidak
                </td>
            </tr>
            @foreach($responPerUnit as $respon)
            <tr>
                <td width="5%" class="bg-green">{{ $loop->iteration }}</td>
                <td>{{ $respon['pertanyaan'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="padding: 0;margin: 0">
                        Tanggapan : <br>
                        {{ $respon['jawaban'] }}
                    </p>
                </td>
                <td>
                    {{ $respon['memuaskan'] }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endforeach

    <br>

    <table class="table-full table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td class="bg-green">Pengetahuan kandidat adalah</td>
                <td><b class="unicode">{!! $isian['pengetahuan_kandidat'] == 'Memuaskan' ? '&#10003;' : '' !!}</b>Memuaskan</td>
                <td><b class="unicode">{!! $isian['pengetahuan_kandidat'] == 'Tidak Memuaskan' ? '&#10003;' : '' !!}</b>Tidak Memuaskan</td>
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
                    @endif
                </td>
            </tr>
            @foreach($uji->getAsesorUji(false) as $asesor)
            <tr>
                <td class="bg-green">Tanda Tangan Asesor {{ $loop->iteration }} : </td>
                <td>
                    @if($asesor->getTTD(false)->count() > 0)
                    <img width="200" src="{{ $asesor->getTTD(false)->random()->ttd }}">
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>