<html>
    <head>
        <title>MAK 06</title>
        @include('form.layouts.style')
    </head>

    <body>
        <h1 class="fs-14">FR-MAK-06.  MENINJAU PROSES ASESMEN</h1>

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
        <br>
        <b>Penjelasan :</b>
        <ol>
            <li>Meninjau proses sesmen adalah kegiatan kaji ulang yang dilaksanakan oleh Asesor Kompetensi yang ditugskan terhadap proses pelaksanaan asesmen.</li>
            <li>Kaji ulang dilakukan terhadap proses asesmen pada satu skema sertifikasi.</li>
        </ol>

        <table class="table-full table-pd-5 table-border" border="1">
            <tr class="bg-biru text-bold text-center">
                <td rowspan="2">No.</td>
                <td class="valign-middle" width="40%" rowspan="2">Aspek yang dikaji Ulang</td>
                <td colspan="3">Hasil Kaji Ulang</td>
            </tr>
            <tr class="bg-biru text-italic text-center valign-middle">
                <td>Ya</td>
                <td>Belum</td>
                <td width="30%">Rekomendasi perbaikan</td>
            </tr>

            @php
            $daftarAspek = [
                'Apakah rencana asesmen memuat rencana pengumpulan bukti seperti yang digambarkan pada standar kompetensi yang diukur?',
                'Apakah rencana asesmen memastikan bukti yang dikumpulkan memenuhi kriteria bukti berkualitas?',
                'Apakah metoda yang dipilih dapat secara konsisten mengumpulkan bukti yang berkualitas?',
                'Apakah metoda yang dipilih dapat secara konsisten mengumpulkan bukti yang berkualitas?',
                'Apakah metoda yang dipilih dapat secara fleksibel menguji peserta sesuai dengan latar belakangnya?',
                'Apakah sumber daya asesmen yang ditetapkan dapat secara konsisten membantu peserta untuk memperlihatkan kompetensinya?',
                'Apakah waktu asesmen yang ditetapkan sudah memenuhi standar kinerja yang sesuai?',
                'Apakah perangkat asesmen konsisten mengukur yang seharusnya diukur sesuai dengan tuntutan standar kompetensi?',
                'Apakah perangkat asesmen merefleksikan tuntutan standar terbaik yang ditetapkan di tempat kerja?',
                'Apakah konsultasi pra asesmen yang dilaksanakan dapat membantu peserta mempersiapkan diri untuk memperlihatkan kompetensinya?',
                'Apakah bukti yang dikumpulkan selama asesmen secara konsisten mengunakan metoda yang dipilih dalam rencana asesmen?',
                'Apakah bukti yang dikumpulkan telah memenuhi aspek pengumpulan bukti VATM?',
                'Apakah keputusan asesmen dilakukan melalui proses mengkaji bukti yang dikumpulkan terhadap kriteria bukti berkualitas?',
                'Apakah kepurtusan asesmen dibuat mengacu pada aspek pengumpulan bukti Valid Asli Terkini dan Memadai?',
                'Apakah peserta diberikan umpan balik  hasil asesmen secara konstruktif?',
                'Apabila keputusan asesmen belum kompeten, apakah peserta menerima keputusan dan tahu apa yang seharusnya ditindaklanjuti?'
            ];
            @endphp

            @foreach ($daftarAspek as $aspek)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $aspek }}</td>
                    <td><b class="unicode">&#10003;</b></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </table>

        <table class="table-full table-pd-5 table-border" border="1">
            <tr class="bg-biru">
                <td rowspan="2" class="text-bold">Aspek yang dikaji Ulang</td>
                <td colspan="5" class="text-bold">Bukti Pemenuhan terhadap Dimensi Kompetensi <br/>
                    (tuliskan jenis bukti & jenis perangkatnya)
                </td>
            </tr>
            <tr class="bg-biru text-italic">
                <td>Task Skill </td>
                <td>Task Mgmnt  Skill</td>
                <td>Contingency Mgmnt Skill</td>
                <td>Job Role/ Environment Skill</td>
                <td>Transfer Skill</td>
            </tr>
            <tr>
                <td>
                    <b>Konsistensi keputusan asesmen</b><br>
                    Apakah bukti kompetensi yang dikumpulkan dari hasil asesmen memenuhi dimensi kompetensi                        
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6">
                    Rekomendasi perbaikan :
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </td>
            </tr>
        </table>

        <table class="table-full table-pd-5 table-border" border="1">
            <tr>
                <td width="50%" class="text-bold" colspan="2">Bagian Sertifikasi :</td>
                <td class="text-bold" colspan="2">Asesor : </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td></td>
                <td>Nama</td>
                <td>Asesor 1</td>
            </tr>
            <tr>
                <td>No. Reg.</td>
                <td>472346328</td>
                <td>No. Reg.</td>
                <td>1351263</td>
            </tr>
            <tr>
                <td>Tanda tangan/<br>Tanggal</td>                
                <td></td>
                <td>Tanda tangan/<br>Tanggal</td>
                <td></td>
            </tr>
        </table>
    </body>
</html>