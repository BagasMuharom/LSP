<html>
    <head>
        <title>MAK 05</title>

        @include('form.layouts.style')
    </head>

    <body>
        <h1 class="fs-14">FR-MAK-05. FORMULIR LAPORAN ASESMEN</h1>

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
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">TUK</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">Nama Asesor</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">Tanggal</td>
                    <td>:</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <span class="fs-11">* Coret yang tidak perlu</span>

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
                        <td class="text-center"><b class="unicode">{!! $uji->isLulus() ? '&#10003;' : '' !!}</b></td>
                        <td class="text-center"><b class="unicode">{!! $uji->isLulus() ? '' : '&#10003;' !!}</b></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <span class="fas-12">** tuliskan Kode dan Judul Unit Kompetensi yang dinyatakan BK      </span>

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

        <table class="table-full table-pd-5 table-border" border="1">
            <tr>
                <td width="50%" class="text-bold" colspan="2">Penanggung Jawab Pelaksanaan Asesmen :</td>
                <td class="text-bold" colspan="2">Asesor : </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>Soeparno</td>
                <td>Nama</td>
                <td>Asesor 1</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>Ketua LSP Unesa</td>
                <td>No. Reg.</td>
                <td>1351263</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Tanda tangan/<br>Tanggal</td>
                <td></td>
            </tr>
        </table>
    </body>
</html>