<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 1.54cm;
        }
        body {
            font-size: 10pt;
        }
        .bold {
            font-weight: bold;
        }
        td {
            font-size: 10pt;
        }
        .center {
            text-align: center
        }
        .f-14 {
            font-size: 14px;
        }
        .f-9 {
            font-size: 9pt;
        }
        .collapse {
            border-collapse: collapse
        }
        .full {
            width: 100%;
        }
        #profil tr td {
            padding: 7px;
        }
        #profil tr td:first-child {
            width: 45%
        }
        #syarat tr td {
            padding: 5px;
        }
        #syarat thead {
            text-transform: uppercase;
            font-weight: bold;
        }
        #syarat {
            margin-top: 20px;
        }
        #ttd {
            width: 90%;
            margin: 20px auto 0;
        }
        #ttd tr td {
            padding: 2px
        }
        #ttd tr:last-child td {
            padding: 5px;
        }
        footer {
            position: fixed;
            bottom: 40px;
        }
        footer img {
            width: 300px;
        }
        .unicode {
            font-family: Dejavu Sans
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <table border="1" class="collapse full">
        <tbody>
            <tr>
                <td rowspan="5" class="center">
                    <img src="{{ asset('img/logo.png') }}" width="80"/>
                </td>
                <td rowspan="2" class="bold center" width="25%">FORMULIR</td>
                <td>No. Dokumen</td>
                <td style="text-align:center">:</td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td>Edisi</td>
                <td style="text-align:center">:</td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td rowspan="3" class="bold center" width="25%">PELAKSANAAN VERIFIKASI & VALIDASI BERKAS ASSESI</td>
                <td>Revisi</td>
                <td style="text-align:center">:</td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td>Tanggal Terbit</td>
                <td style="text-align:center">:</td>
                <td width="40%"></td>
            </tr>
            <tr>
                <td>Halaman</td>
                <td style="text-align:center">:</td>
                <td width="40%">1 dari 1</td>
            </tr>
        </tbody>
    </table>

    {{-- Profil --}}
    <h4 class="bold;margin: 0">PROFIL ASESI</h4>
    <table border="1" class="collapse full" id="profil">
        <tbody>
            <tr>
                <td class="bold">NAMA ASESI</td>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td class="bold">PROGRAM STUDI</td>
                <td>{{ $mahasiswa->getProdi(false)->nama }}</td>
            </tr>
            <tr>
                <td class="bold">ALAMAT</td>
                <td>{{ $mahasiswa->alamat }}</td>
            </tr>
            <tr>
                <td class="bold">SKEMA SERTIFIKASI</td>
                <td>{{ $skema->nama }}</td>
            </tr>
            <tr>
                <td class="bold">NO. SKEMA</td>
                <td>{{ $skema->kode }}</td>
            </tr>
            <tr>
                <td class="bold">EMAIL</td>
                <td>{{ $mahasiswa->email }}</td>
            </tr>
            <tr>
                <td class="bold">TELEPON/HP</td>
                <td>{{ $mahasiswa->no_telepon }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Syarat --}}
    <table border="1" class="collapse full" id="syarat">
        <thead class="center">
            <tr>
                <td rowspan="2">NO.</td>
                <td rowspan="2">LEGALITAS DAN BERKAS</td>
                <td rowspan="2">Ket</td>
                <td colspan="2">TEMUAN</td>
            </tr>
            <tr>
                <td>ADA</td>
                <td>BELUM ADA</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>KTP</td>
                <td>M</td>
                <td style="text-align:center"><b class="unicode">&#10003;</b></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Foto 3x4 (2 lembar background merah)</td>
                <td>M</td>
                <td style="text-align:center"><b class="unicode">&#10003;</b></td>
                <td></td>
            </tr>
            @foreach ($persyaratan as $syarat)
            <tr>
                <td>{{ $loop->iteration + 2 }}</td>
                <td>{{ $syarat->nama }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <td>{{ $persyaratan->count() + 3 }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <p class="f-9">
        Keterangan : M = Mandatory ; sesuatu yang menjadi keharusan<br/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;V = Voluntary ; sesuatu yang bersifat sukarela
    </p>

    {{-- Tanda tangan --}}
    <table border="1" class="collapse full f-9" id="ttd">
        <tbody>
            <tr>
                <td>Tanggal :</td>
                <td>Tanggal :</td>
                <td>Tanggal :</td>
            </tr>
            <tr>
                <td>Yang Menyerahkan,</td>
                <td>Yang Menerima,</td>
                <td>Petugas Verifikasi & Validasi,</td>
            </tr>
            <tr>
                <td class="center" style="padding-top: 60px">........................</td>
                <td class="center" style="padding-top: 60px">........................</td>
                <td class="center" style="padding-top: 60px">........................</td>
            </tr>
        </tbody>
    </table>
    
    <footer>
        <img src="{{ asset('img/footer.png') }}">
    </footer>
</body>
</html>