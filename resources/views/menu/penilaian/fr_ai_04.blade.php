@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Penilaian | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')
    <div class="card card-body">
        <h4><b>FR.AI.04. CEKLIS EVALUASI PORTOFOLIO</b></h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td>Nama Asesi</td>
                    <td>{{ $uji->getMahasiswa(false)->nama }}</td>
                </tr>
                <tr>
                    <td>Nama Asesor</td>
                    <td>
                        @foreach($uji->getAsesorUji(false) as $asesor)
                            {{ $loop->iteration.'. '.$asesor->nama }}<br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Tempat kerja</td>
                    <td>{{ $uji->getTempatUji(false)->nama }}</td>
                </tr>
                <tr>
                    <td>Nomor dan Judul Skema</td>
                    <td>{{ $uji->getSkema(false)->kode.' / '.$uji->getSkema(false)->nama }}</td>
                </tr>
            </table>
        </div>
    </div>

    <form action="{{ route('penilaian.eval.fr-ai-04', ['uji' => encrypt($uji->id)]) }}" method="post">
        @csrf
        <div id="form">

        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-info" onclick="tambah_form()">
                Tambah form
            </button>
            <button class="btn btn-success" type="submit">
                Simpan
            </button>
        </div>
    </form>

    <div id="form-frai04" style="visibility: hidden">
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Jenis Portofolio</td>
                        <td>
                            <textarea class="form-control" name="jenis[]" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Nomor dan Judul Unit Kompetensi</td>
                        <td>
                            <select name="unit[]" class="form-control" required>
                                <option value="">Pilih Unit</option>
                                @foreach($uji->getSkema(false)->getSkemaUnit(false) as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->kode.' / '.$unit->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td>Dokumen portofolio menunjukkan kepatuhan terhadap aturan bukti</td>
                        @foreach($types as $type)
                            <td>{{ $type }}</td>
                        @endforeach
                        <td>Aksi</td>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <button type="button" class="btn btn-info btn-block" onclick="tambah_validasi($(this), 'fcounter')">Tambah validasi</button>
                <br>

                <table class="table table-bordered">
                    <tr>
                        <td>
                            Sebagai tindak lanjut dari hasil verifikasi bukti, substansi materi di bawah ini harus
                            diklarifikasi selama wawancara:
                            <br>
                            <textarea class="form-control" name="tindak_lanjut[]"></textarea>
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <tr>
                        <td>
                            Bukti tambahan diperlukan pada unit / elemen kompetensi sebagai berikut:
                            <br>
                            <textarea class="form-control" name="bukti_tambahan[]"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <button type="button" class="btn btn-danger" onclick="hapus($(this))">Hapus</button>
        </div>
    </div>

    <table style="visibility: hidden">
        <tbody id="portofolio-row">
        <tr>
            <td>
                <select class="form-control" name="dokumen_[]" required>
                    @foreach($uji->getPortofolio() as $file => $nama)
                        <option value="{{ $nama }}">{{ $nama }}</option>
                    @endforeach
                </select>
            </td>
            @foreach($types as $type)
                <td>
                    <select class="form-control" name="{{ strtolower($type) }}_[]" required>
                        <option value="Ya" >Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </td>
            @endforeach
            <td>
                <button type="button" class="btn btn-danger" onclick="$(this).parent().parent().remove()">Hapus</button>
            </td>
        </tr>
        </tbody>
    </table>
@endsection

@push('js')
    <script>
        f = 0
        v = 0

        function tambah_form() {
            subhtml = $('#form-frai04').html()
            subhtml = subhtml.replace('onclick="tambah_validasi', ' id="tv' + f + '" onclick="tambah_validasi')
            subhtml = subhtml.replace('fcounter', f)
            subhtml = subhtml.replace('name="jenis[]"', 'id="jenis' + f + '" name="jenis[]"')
            subhtml = subhtml.replace('name="unit[]"', 'id="unit' + f +'" name="unit[]"')
            subhtml = subhtml.replace('name="tindak_lanjut[]"', 'id="tl' + f +'" name="tindak_lanjut[]"')
            subhtml = subhtml.replace('name="bukti_tambahan[]"', 'id="bt' + f +'" name="bukti_tambahan[]"')
            $('#form').append(subhtml)
            f++
        }

        function hapus(that) {
            swal({
                title: "Anda yakin ingin menghapus form ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((choice) => {
                if (choice) {
                    that.parent().remove()
                }
            })
        }

        function tambah_validasi(that, fcounter) {
            subhtml = $('#portofolio-row').html()
            subhtml = subhtml.replace('_[]', '_' + fcounter + '[]')
            subhtml = subhtml.replace('_[]', '_' + fcounter + '[]')
            subhtml = subhtml.replace('_[]', '_' + fcounter + '[]')
            subhtml = subhtml.replace('_[]', '_' + fcounter + '[]')
            subhtml = subhtml.replace('_[]', '_' + fcounter + '[]')

            subhtml = subhtml.replace('name="dokumen_', 'id="d_' + v +'_' + fcounter + '" name="dokumen_')
            subhtml = subhtml.replace('name="valid_', 'id="v_' + v +'_' + fcounter + '" name="valid_')
            subhtml = subhtml.replace('name="memadai_', 'id="m_' + v +'_' + fcounter + '" name="memadai_')
            subhtml = subhtml.replace('name="asli_', 'id="a_' + v +'_' + fcounter + '" name="asli_')
            subhtml = subhtml.replace('name="terkini_', 'id="t_' + v +'_' + fcounter + '" name="terkini_')
            that.prev().children().eq(1).append(subhtml)
            v++
        }

        data_sebelum = JSON.parse('{!! $uji->getEvaluasiPortofolio()->toJson() !!}')

        data_sebelum.forEach(function (item, index) {
            tambah_form()
            $('#jenis' + index).html(item.jenis)
            $('#unit' + index).val(item.unit.id)
            $('#tl' + index).html(item.tindak_lanjut)
            $('#bt' + index).html(item.bukti_tambahan)
            item.bukti.forEach(function (subitem, subindex) {
                $('#tv' + index).click()
                $('#d_' + (v - 1) + '_' + index).val(item.bukti[subindex].dokumen)
                $('#v_' + (v - 1) + '_' + index).val(item.bukti[subindex].valid)
                $('#m_' + (v - 1) + '_' + index).val(item.bukti[subindex].memadai)
                $('#a_' + (v - 1) + '_' + index).val(item.bukti[subindex].asli)
                $('#t_' + (v - 1) + '_' + index).val(item.bukti[subindex].terkini)
            })
        })
    </script>
@endpush