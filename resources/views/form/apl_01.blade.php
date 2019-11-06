<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>APL 01</title>
    <style>
        @page {
            margin: 2cm;
        }

        * {
            box-sizing: border-box
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
        }
        html, body {
            font-size: 11pt;
        }

        .fs-11 {
            font-size: 11pt;
        }

        .fs-12 {
            font-size: 12pt;
        }

        .fs-14 {
            font-size: 14pt;
        }

        .table-pd-5 td {
            padding: 5px;
            vertical-align: top
        }

        .table-full {
            width: 100%;
        }

        .table-border {
            border-collapse: collapse;
        }

        .unicode {
            font-family: DejaVu Sans;
        }

        .bg-biru {
            background-color: rgb(198, 217, 241);
        }
    </style>
</head>
<body>
    <h4 class="fs-14">FR-APL-01. FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI</h4>
    <br>
    <h5 class="fs-12">Bagian 1 :  Rincian Data Pemohon Sertifikasi</h5>
    <p>Pada bagian ini,  cantumkan data pribadi, data pendidikan formal serta data pekerjaan anda pada saat ini.</p>

    <p><b>a. Data Pribadi</b></p>
    <div>
        <table class="fs-11 table-pd-5">
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <td>Tempat / Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $mahasiswa->tempat_lahir }} / {{ formatDate(Carbon\Carbon::parse($mahasiswa->tgl_lahir), false, false) }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $mahasiswa->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <td>Kebangsaan</td>
                    <td>:</td>
                    <td>Indonesia</td>
                </tr>
                <tr>
                    <td>Alamat rumah</td>
                    <td>:</td>
                    <td>
                        {{ $mahasiswa->alamat }} <br>
                        Kodepos : ____________
                    </td>
                </tr>
                <tr>
                    <td>Kebangsaan</td>
                    <td>:</td>
                    <td>Indonesia</td>
                </tr>
                <tr>
                    <td>No. Telepon/Email</td>
                    <td>:</td>
                    <td>
                        Rumah : ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kantor : ________________ <br>
                        HP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $mahasiswa->no_telepon }}&nbsp;&nbsp;&nbsp;&nbsp;E-mail : ________________
                    </td>
                </tr>
                <tr>
                    <td>Pendidikan Terakhir</td>
                    <td>:</td>
                    <td>{{ $mahasiswa->pendidikan }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p><b>b. Data Pekerjaan Sekarang</b></p>
    <div>
        <table class="fs-11 table-pd-5">
            <tbody>
                <tr>
                    <td>Nama Lembaga/ Perusahaan </td>
                    <td>:</td>
                    <td>Universitas Negeri Surabaya</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Mahasiswa</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>
                        Jl. Ketintang
                        <br>
                        Kode pos : 60222
                    </td>
                </tr>
                <tr>
                    <td>No. Telp/Fax/E-mail</td>
                    <td>:</td>
                    <td>
                        Telp : ________________ Fax : ________________
                        <br>
                        E-mail : ________________
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h5 class="fs-12"><b>Bagian  2 :  Data Sertifikasi</b></h5>
    <p>Tuliskan Judul dan Nomor Skema Sertifikasi, Tujuan Asesmen  serta Daftar Unit Kompetensi sesuai kemasan pada skema sertifikasi yang anda ajukan untuk mendapatkan pengakuan sesuai dengan latar belakang pendidikan, pelatihan serta pengalaman kerja yang anda miliki.</p>

    <table class="table-full fs-11 table-pd-5" border="1" style="border-collapse: collapse">
        <tbody>
            <tr>
                <td rowspan="2">
                    Skema Sertifikasi/ Klaster Asesmen
                </td>
                <td>Judul</td>
                <td>:</td>
                <td colspan="3">{{ $skema->nama }}</td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td colspan="3">{{ $skema->kode }}</td>
            </tr>
            <tr>
                <td colspan="2">Tujuan Asesmen</td>
                <td>:</td>
                <td>
                    <b style="border: 1px solid #000;padding: 3px" class="unicode">&#10003;</b> Sertifikasi
                </td>
                <td>
                    <b style="border: 1px solid #000;padding: 5px" class="unicode">&nbsp;&nbsp;</b> Sertifikasi Ulang
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <p style="page-break-before: always"><b>Daftar Unit Kompetensi</b></p>
    <table class="fs-11 table-pd-5 table-full" border="1" style="border-collapse: collapse">
        <thead style="text-align:center" class="bg-biru">
            <tr>
                <th>No.</th>
                <th>Kode Unit</th>
                <th>Judul Unit</th>
                <th>Jenis Standar (Standar Khusus/Standar Internasional/SKKNI)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($skema->getSkemaUnit(false) as $unit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $unit->kode }}</td>
                <td>{{ $unit->nama }}</td>
                <td>SKKNI</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <h5 class="fs-12">Bagian 3 : Bukti Kelengkapan Pemohon</h5>

    <br>

    <h5 class="fs-11">a. Bukti kelengkapan persyaratan dasar pemohon :</h5>

    <br>

    <table class="fs-11 table-pd-5 table-full table-border" border="1">
        <thead style="text-align: center" class="bg-biru">
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Bukti Persyaratan</th>
                <th colspan="2">Ada</th>
                <th rowspan="2">Tidak ada</th>
            </tr>
            <tr>
                <th>memenuhi syarat</th>
                <th>tidak memenuhi syarat</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 5;
            @endphp
            @foreach ($persyaratan as $syarat)
            @php
            $total--;
            @endphp
            <tr>
                <td>{{ $loop->iteration + 2 }}</td>
                <td>{{ $syarat->nama }}</td>
                <td style="text-align: center;">
                    <b class="unicode">
                        {!! !is_null($uji->getHelper('verifikasi_syarat')) && $uji->getHelper('verifikasi_syarat')->contains($syarat->id) ? '&#10003;' : ''!!}
                    </b>
                </td>
                <td></td>
                <td style="text-align: center;">
                    <b class="unicode">
                        {!! !is_null($uji->getHelper('verifikasi_syarat')) && !$uji->getHelper('verifikasi_syarat')->contains($syarat->id) ? '&#10003;' : ''!!}
                    </b>
                </td>
            </tr>
            @endforeach

            @for($i = 1; $i <= $total; $i++)
                <tr>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>
                </tr>
            @endfor
        </tbody>
    </table>

    <h5 style="page-break-before: always" class="fs-11">b. Bukti kompetensi yang relevan :</h5>
    
    <br>

    <table class="fs-11 table-pd-5 table-full table-border" border="1">
        <thead style="text-align:center" class="bg-biru">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Rincian Bukti Pendidikan/Pelatihan, Pengalaman Kerja, Pengalaman Hidup</th>
                <th colspan="2">Lampiran Bukti</th>
            </tr>
            <tr>
                <th>Ada</th>
                <th>Tidak Ada</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 3;
            @endphp

            @foreach ($uji->getBuktiKompetensi() as $file => $bukti)
            @php
            $total--;
            @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bukti }}</td>
                    <td style="text-align: center;">
                        <b class="unicode">
                            {!! !is_null($uji->getHelper('verifikasi_bukti')) && $uji->getHelper('verifikasi_bukti')->contains($bukti) ? '&#10003;' : ''!!}
                        </b>
                    </td>
                    <td></td>
                </tr>
            @endforeach

            @for($i = 1; $i <= $total; $i++)
                <tr>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>
                </tr>
            @endfor
        </tbody>
    </table>

    <br>

    <table class="table-full fs-11 table-pd-5 table-border" border="1">
        <tbody>
            <tr>
                <td rowspan="3" width="50%">
                    <b>Rekomendasi (diisi oleh LSP):</b><br>
                    Berdasarkan ketentuan persyaratan dasar pemohon, maka pemohon: 
                    Diterima sebagai peserta sertifikasi
                </td>
                <td colspan="2">
                    <b>Pemohon : </b>
                </td>
            </tr>

            <tr>
                <td>Nama</td>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>

            <tr>
                <td>Tanda tangan/Tanggal</td>
                <td>
                    @if($uji->getMahasiswa(false)->getTTD(false)->count() > 0)
                        <img width="200" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}" class="img-responsive">
                    @endif
                </td>                    
            </tr>

            <tr>
                <td rowspan="4"><b>Catatan : </b></td>
                <td colspan="2"><b>Admin LSP : </b></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $admin->nama }}</td>
            </tr>
            <tr>
                <td>NIK LSP</td>
                <td>
                    {{ $admin->nip }}
                </td>
            </tr>
            <tr>
                <td>Tanda tangan/Tanggal</td>
                <td style="text-align: center;">
                    @if($admin->getTTD(false)->count() > 0)
                    <img width="200" src="{{ $admin->getTTD(false)->random()->ttd }}">
                    @endif
                    {{ formatDate($uji->created_at, false, false) }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>