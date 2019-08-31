<html lang="en">
<head>
    <title>MAK 01</title>
    @include('form.layouts.style')
</head>
<body>
    <h1 class="fs-14">FR-MAK-01. FORMULIR PERSETUJUAN ASESMEN DAN KERAHASIAAN</h1>
    <br>
    <table class="table-full table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td colspan="4">
                    Persetujuan Asesmen ini untuk menjamin bahwa Peserta telah diberi arahan secara rinci tentang perencanaan dan proses asesmen
                </td>
            </tr>

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
                <td colspan="2">Nama Peserta</td>
                <td style="width: 1%">:</td>
                <td>
                    {{ $uji->getMahasiswa(false)->nama }}
                </td>
            </tr>
            
            <tr>
                <td colspan="2" rowspan="3">Bukti yang akan dikumpulkan</td>
                <td style="width: 1%">:</td>
                <td>
                    Bukti TL :
                </td>
            </tr>
            
            <tr>
                <td style="width: 1%">:</td>
                <td>
                    Bukti L : Rekaman hasil observasi
                </td>
            </tr>
            
            <tr>
                <td style="width: 1%">:</td>
                <td>
                    Bukti T : Rekaman hasil {{ strtolower(implode(', rekaman hasil ', $daftarTesYangDilakukan)) }}
                </td>
            </tr>
            
            <tr>
                <td colspan="4">
                    Pelaksanaan asesmen disepakati pada :<br/><br/>
                    Hari/ Tanggal : <br/><br/>
                    Tempat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                </td>
            </tr>
            
            <tr>
                <td colspan="4">
                    <b>
                    Peserta Sertifikasi :<br/><br/>
                    Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.
                    </b>
                </td>
            </tr>
            
            <tr>
                <td colspan="4">
                    <b>
                    Asesor :<br/><br/>
                    Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan saya sebagai asesor dalam pekerjaan Asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai Asesor yang ditugaskan oleh LSP.
                    </b>
                </td>
            </tr>
            
            <tr>
                <td colspan="4">
                    <table>
                        <tbody>
                            <tr>
                                <td style="vertical-align: bottom">Tanda Tangan Peserta :</td>
                                <td style="width: 30%">
                                    <img width="150" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}"><br>
                                    <span style="font-size: 9pt">{{ ucwords($uji->getMahasiswa(false)->nama) }}</span>
                                </td>
                                <td style="vertical-align: bottom">Tanggal :</td>
                                <td></td>
                            </tr>
                            @foreach ($uji->getAsesorUji(false) as $asesor)
                            <tr>
                                <td style="vertical-align: bottom">Tanda Tangan Asesor :</td>
                                <td style="width: 30%">
                                @if($asesor->getTTD()->count() > 0)
                                    <img width="150" src="{{ $asesor->getTTD(false)->random()->ttd }}"><br>
                                    @endif
                                    <span style="font-size: 9pt">{{ $asesor->nama }}</span>
                                </td>
                                <td style="vertical-align: bottom">Tanggal :</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <i>*) Coret yang tidak perlu</i>
</body>
</html>