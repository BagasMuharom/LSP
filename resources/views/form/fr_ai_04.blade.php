<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .center {
            text-align: center
        }
        table, th, td {
            border: 1px solid black;
        }

        .bg-hijau {
            background-color: rgb(231, 241, 162);
        }

        .unicode {
            font-family: DejaVu Sans;
        }
    </style>
</head>

<body>
<h3><b>FR.AI.04 CEKLIS EVALUASI PORTOFOLIO</b></h3>
<table>
    <tr>
        <td class="bg-hijau"><b>Nama Asesi:</b></td>
        <td>{{ $uji->getMahasiswa(false)->nama }}</td>
    </tr>
    <tr>
        <td class="bg-hijau"><b>Nama Asesor:</b></td>
        <td>
            @foreach ($uji->getAsesorUji(false) as $asesor)
                {{ $loop->iteration }}. {{ $asesor->nama }}<br>
            @endforeach
        </td>
    </tr>
    <tr>
        <td class="bg-hijau"><b>Tempat kerja:</b></td>
        <td>{{ $uji->getTempatUji(false)->nama }}</td>
    </tr>
    <tr>
        <td class="bg-hijau"><b>Nomor dan Judul Skema:</b></td>
        <td>{{ $uji->getSkema(false)->kode }} {{ $uji->getSkema(false)->nama }}</td>
    </tr>
    <tr>
        <td class="bg-hijau"><b>Jenis Portofolio:</b></td>
        <td>{{ $form->jenis }}</td>
    </tr>
</table>
<br>
@foreach($form->validasi as $unit => $datas)
    <table>
        <tr>
            <td width="30%"><b>Nomor dan Judul Unit Kompetensi:</b></td>
            <td width="70%">{{ $unit }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td rowspan="2"><b>Dokumen portofolio menunjukkan kepatuhan terhadap aturan bukti:</b></td>
            <td colspan="2" class="bg-hijau"><b>Valid</b></td>
            <td colspan="2" class="bg-hijau"><b>Memadai</b></td>
            <td colspan="2" class="bg-hijau"><b>Asli</b></td>
            <td colspan="2" class="bg-hijau"><b>Terkini</b></td>
        </tr>
        <tr>
            <td>Ya</td>
            <td>Tidak</td>

            <td>Ya</td>
            <td>Tidak</td>

            <td>Ya</td>
            <td>Tidak</td>

            <td>Ya</td>
            <td>Tidak</td>
        </tr>
        @foreach($datas as $data)
            <tr>
                <td>{{ $loop->iteration }}. {{ $data->dokumen }}</td>

                @foreach(['valid', 'memadai', 'asli', 'terkini'] as $v)
                    <td class="unicode">@if($data->{$v} == 'Ya') &#10003; @endif</td>
                    <td class="unicode">@if($data->{$v} == 'Tidak') &#10003; @endif</td>
                @endforeach
            </tr>
        @endforeach
    </table>
    <br>
@endforeach

<br>
<table>
    <tr>
        <td>
            <b>Sebagai tindak lanjut dari hasil verifikasi bukti, substansi materi di bawah ini harus diklarifikasi selama wawancara:</b><br>
            {{ $form->tindak_lanjut }}
        </td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td>
            <b>Bukti tambahan diperlukan pada unit / elemen kompetensi sebagai berikut:</b><br>
            {{ $form->bukti_tambahan }}
        </td>
    </tr>
</table>
<table>
    <tbody>
    <tr>
        <td width="35%" class="bg-hijau"><b>Tanda Tangan Asesi :</b></td>
        <td>
            @if($uji->getMahasiswa(false)->getTTD(false)->count() > 0)
                <img width="200" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}"
                     class="img-responsive">
            @endif
        </td>
    </tr>
    @foreach($uji->getAsesorUji(false) as $asesor)
        <tr>
            <td class="bg-hijau"><b>Tanda Tangan Asesor {{ $loop->iteration }} :</b></td>
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