@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Penilaian | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <form action="{{ route('penilaian.eval.fr-ai-04', ['uji' => encrypt($uji->id)]) }}" method="post">
        @csrf
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
                    <tr>
                        <td>Jenis Portofolio</td>
                        <td>
                            <textarea rows="5" class="form-control" name="jenis"
                                      placeholder="Sampel pekerjaan yang disusun kandidat, produk dengan dokumentasi pendukung, bukti sejarah, jurnal atau buku catatan, informasi tentang pengalaman hidup (bisa lebih dari satu)"
                                      required>{{ $frai04['jenis'] ?? '' }}</textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td>Nomor dan Judul Unit Kompetensi</td>
                        <td>Dokumen portofolio menunjukkan kepatuhan terhadap aturan bukti</td>
                        @foreach($types as $type)
                            <td>{{ $type }}</td>
                        @endforeach
                        <td>Aksi</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($frai04))
                        @php $c = 0 @endphp
                        @foreach($frai04['unit'] as $unit_id)
                            <tr>
                                <td>
                                    <select name="unit[]" class="form-control" required>
                                        <option value="">Pilih Unit</option>
                                        @foreach($uji->getSkema(false)->getSkemaUnit(false) as $unit)
                                            <option value="{{ $unit->id }}"
                                                    @if($unit_id == $unit->id) selected @endif>{{ $unit->kode.' '.$unit->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="dokumen[]" required>
                                        <option value="-">Pilih Dokumen</option>
                                        @foreach($uji->getPortofolio() as $file => $nama)
                                            <option value="{{ $nama }}"
                                                    @if($nama == $frai04['dokumen'][$c]) selected @endif>{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                @foreach($types as $type)
                                    <td>
                                        <select class="form-control" name="{{ strtolower($type) }}[]" required>
                                            <option value="{{ $frai04[strtolower($type)][$c] }}">{{ $frai04[strtolower($type)][$c] }}</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </td>
                                @endforeach
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="$(this).parent().parent().remove()">Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-info btn-block" onclick="tambah_validasi($(this), 'fcounter')">Tambah
                validasi
            </button>
            <br>

            <table class="table table-bordered">
                <tr>
                    <td>
                        Sebagai tindak lanjut dari hasil verifikasi bukti, substansi materi di bawah ini harus
                        diklarifikasi selama wawancara:
                        <br>
                        <textarea rows="5" class="form-control"
                                  name="tindak_lanjut">{{ $frai04['tindak_lanjut'] ?? '' }}</textarea>
                    </td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <td>
                        Bukti tambahan diperlukan pada unit / elemen kompetensi sebagai berikut:
                        <br>
                        <textarea rows="5" class="form-control"
                                  name="bukti_tambahan">{{ $frai04['bukti_tambahan'] ?? '' }}</textarea>
                    </td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>Tanda Tangan Asesi :</td>
                    <td>
                        @if($uji->getMahasiswa(false)->getTTD(false)->count() > 0)
                            <img width="200" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}"
                                 class="img-responsive">
                        @endif
                    </td>
                </tr>
                @foreach($uji->getAsesorUji(false) as $asesor)
                    <tr>
                        <td class="bg-green">Tanda Tangan Asesor {{ $loop->iteration }} :</td>
                        <td>
                            @if($asesor->getTTD(false)->count() > 0)
                                <img width="200" src="{{ $asesor->getTTD(false)->random()->ttd }}">
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <button class="btn btn-success btn-lg">Simpan</button>
    </form>
    </div>

    <table style="visibility: hidden">
        <tbody id="portofolio-row">
        <tr>
            <td>
                <select name="unit[]" class="form-control" required>
                    <option value="">Pilih Unit</option>
                    @foreach($uji->getSkema(false)->getSkemaUnit(false) as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->kode.' '.$unit->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control" name="dokumen[]" required>
                    <option value="-">Pilih Dokumen</option>
                    @foreach($uji->getPortofolio() as $file => $nama)
                        <option value="{{ $nama }}">{{ $nama }}</option>
                    @endforeach
                </select>
            </td>
            @foreach($types as $type)
                <td>
                    <select class="form-control" name="{{ strtolower($type) }}[]" required>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </td>
            @endforeach
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove()">Hapus
                </button>
            </td>
        </tr>
        </tbody>
    </table>
@endsection

@push('js')
    <script>
        function tambah_validasi(that, fcounter) {
            subhtml = $('#portofolio-row').html()
            that.prev().children().eq(0).children().eq(1).append(subhtml)
        }
    </script>
@endpush