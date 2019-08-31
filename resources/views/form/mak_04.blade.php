<html>
<head>
    <title>MAK 04</title>
    @include('form.layouts.style')
</head>

<body>
    <h1 class="fs-14">FR-MAK-04. UMPAN BALIK DARI PESERTA</h1>
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
                <td>{{ $uji->getSkema(false)->nama }}</td>
            </tr>
            
            <tr>
                <td style="width: 10%">
                    Nomor
                </td>
                <td style="width: 1%">:</td>
                <td>{{ $uji->getSkema(false)->kode }}</td>
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
                        @foreach ($uji->getAsesorUji(false) as $asesor)
                            <li>{{ $asesor->nama }}</li>
                        @endforeach
                    </ol>
                </td>
            </tr>

            <tr>
                <td colspan="2">Tanggal</td>
                <td style="width: 1%">:</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <i>*) Coret yang tidak perlu</i>
    <br><br>
    <table class="table-full table-pd-5 table-border" border="1">
        <thead class="bg-biru" style="text-align: center">
            <tr>
                <th style="vertical-align: middle" rowspan="2">Komponen Umpan Balik</th>
                <th style="vertical-align: middle" colspan="2">Hasil</th>
                <th style="vertical-align: middle" rowspan="2">Catatan/Komentar<br>Peserta</th>
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
                    <td style="text-align: center"><b class="unicode">{!! $isian['jawaban'][$komponen->id]['jawaban'] === 'Ya' ? '&#10003;' : '' !!}</b></td>
                    <td style="text-align: center"><b class="unicode">{!! $isian['jawaban'][$komponen->id]['jawaban'] === 'Tidak' ? '&#10003;' : '' !!}</b></td>
                    <td>{{ $isian['jawaban'][$komponen->id]['komentar'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    Catatan/komentar lainnya (apabila ada) :<br>
                    {{ $isian['catatan'] }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>