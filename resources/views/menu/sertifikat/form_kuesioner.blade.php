@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Isi Kuesioner')
    
@section('content')
    @card(['id' => 'form'])
        @slot('title', 'Isi Kuesioner')

        @json($errors->all())

        <form action="{{ route('sertifikat.kuesioner.isi', ['sertifikat' => encrypt($sertifikat->id)]) }}" method="post">
            @csrf

            @formgroup(['row' => true])
                <label class="col-lg-4"><b>1.</b> Nama Pemegang Sertifikat Kompetensi</label>
                <div class="col-lg-8">
                    {{ $sertifikat->nama_pemegang }}
                </div>
            @endformgroup
            
            @formgroup(['row' => true])
                <label class="col-lg-4"><b>2.</b> Nama Skema Kompetensi</label>
                <div class="col-lg-8">
                    {{ $skema->nama }}
                </div>
            @endformgroup
            
            @formgroup(['row' => true])
                <label class="col-lg-4"><b>3.</b> Berlakunya Sertifikat</label>
                <div class="col-lg-8">
                    {{ formatDate(Carbon\Carbon::parse($sertifikat->issue_date), false, false) }} sampai {{ formatDate(Carbon\Carbon::parse($sertifikat->expire_date), false, false) }}
                </div>
            @endformgroup

            @formgroup(['row' => true])
                <label class="col-lg-4"><b>4.</b> Alamat Tempat Tinggal</label>
                <div class="col-lg-8">
                    <b>Alamat : </b>{{ $mahasiswa->alamat }} <br>
                    <b>Kota/Kabupaten : </b>{{ $mahasiswa->kabupaten }} <br>
                    <b>Provinsi : </b>{{ $mahasiswa->provinsi }}
                </div>
            @endformgroup

            @formgroup(['row' => true])
                <label class="col-lg-4"><b>5.</b> No. HP</label>
                <div class="col-lg-8">
                    {{ $mahasiswa->no_telepon }}
                </div>
            @endformgroup

            @formgroup(['row' => true])
                <label class="col-lg-4"><b>6.</b> Alamat Email</label>
                <div class="col-lg-8">
                    {{ $mahasiswa->email }}
                </div>
            @endformgroup

            @formgroup(['row' => true, 'name' => 'kegiatan'])
                <label class="col-lg-4"><b>7.</b> Kegiatan setelah mendapat sertifikat</label>
                <div class="col-lg-8">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="kegiatan" id="kegiatan" value="Bekerja" class="custom-control-input" {{ $errors->count() > 0 ? (old('kegiatan') == 'Bekerja' ? 'checked' : '' ) : '' }}>
                        <label class="custom-control-label" for="kegiatan">Bekerja</label>
                    </div>
                    <div class="input-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="kegiatan" id="wirausaha" value="Wirausaha" class="custom-control-input" {{ $errors->count() > 0 ? (old('kegiatan') == 'Wirausaha' ? 'checked' : '' ) : '' }}>
                            <label class="custom-control-label" for="wirausaha">Wirausaha di bidang (Langsung lanjut ke nomor 13) </label>
                        </div>
                        <div class="input-group-append pl-2">
                            <input type="text" name="wirausaha" id="wirausaha" class="form-control" placeholder="Bidang wirausaha">
                        </div>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="kegiatan" id="belum_ada_kegiatan" value="Belum Ada Kegiatan" class="custom-control-input" {{ $errors->count() > 0 ? (old('kegiatan') == 'Belum Ada Kegiatan' ? 'checked' : '' ) : '' }}>
                        <label class="custom-control-label" for="belum_ada_kegiatan">Belum ada kegiatan (Langsung lanjut ke nomor 13)</label>
                    </div>
                </div>
            @endformgroup

            @formgroup(['name' => 'nama_perusahaan', 'row' => true])
                <label class="col-lg-4"><b>8.</b> Nama Perusahaan</label>
                <div class="col-lg-8">
                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" value="{{ $errors->count() > 0 ? old('nama_perusahaan') : '' }}">
                </div>
            @endformgroup
            
            @formgroup(['name' => 'alamat_perusahaan', 'row' => true])
                <label class="col-lg-4"><b>9.</b> Alamat Perusahaan</label>
                <div class="col-lg-8">
                    <input type="text" name="alamat_perusahaan" id="alamat_perusahaan" class="form-control" value="{{ $errors->count() > 0 ? old('alamat_perusahaan') : '' }}">
                </div>
            @endformgroup
            
            @formgroup(['name' => 'jenis_perusahaan', 'row' => true])
                <label class="col-lg-4"><b>10.</b> Jenis Perusahaan</label>
                <div class="col-lg-8">
                    <input type="text" name="jenis_perusahaan" id="jenis_perusahaan" class="form-control" value="{{ $errors->count() > 0 ? old('jenis_perusahaan') : '' }}">
                </div>
            @endformgroup
            
            @formgroup(['name' => 'tahun_memulai_kerja', 'row' => true])
                <label class="col-lg-4"><b>11.</b> Tahun Memulai Kerja</label>
                <div class="col-lg-8">
                    <input type="number" name="tahun_memulai_kerja" id="tahun_memulai_kerja" class="form-control" value="{{ $errors->count() > 0 ? old('tahun_memulai_kerja') : '' }}">
                </div>
            @endformgroup
            
            @formgroup(['name' => 'relevansi', 'row' => true])
                <label class="col-lg-4"><b>12.</b> Relevansi Sertifikat Kompetensi Bidang dengan Pekerjaan</label>
                <div class="col-lg-8">
                    <input type="text" name="relevansi" id="relevansi" class="form-control" value="{{ $errors->count() > 0 ? old('relevansi') : '' }}">
                </div>
            @endformgroup
            
            @formgroup(['row' => true])
                <label class="col-lg-4"><b>13.</b> Manfaat Sertifikat Kompetensi</label>
                <div class="col-lg-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <b class="mr-2">a.</b>Dapat mempermudah mencari pekerjaan
                            </span>
                        </div>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="mempermudah_mencari_pekerjaan" id="mempermudah_mencari_pekerjaan_ya" value="Ya" class="custom-control-input" {{ $errors->count() > 0 ? (old('mempermudah_mencari_pekerjaan') == 'Ya' ? 'checked' : '' ) : '' }}>
                                    <label class="custom-control-label" for="mempermudah_mencari_pekerjaan_ya">Ya</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="mempermudah_mencari_pekerjaan" id="mempermudah_mencari_pekerjaan_tidak" value="Tidak" class="custom-control-input" {{ $errors->count() > 0 ? (old('mempermudah_mencari_pekerjaan') == 'Tidak' ? 'checked' : '' ) : '' }}>
                                    <label class="custom-control-label" for="mempermudah_mencari_pekerjaan_tidak">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <b class="mr-2">b.</b>Dapat Membedakan Jenis Bidang Pekerjaan 
                            </span>
                        </div>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="membedakan_jenis_pekerjaan" id="membedakan_jenis_pekerjaan_ya" value="Ya" class="custom-control-input" {{ $errors->count() > 0 ? (old('membedakan_jenis_pekerjaan_ya') == 'Ya' ? 'checked' : '' ) : '' }}>
                                    <label class="custom-control-label" for="membedakan_jenis_pekerjaan_ya">Ya</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="membedakan_jenis_pekerjaan" id="membedakan_jenis_pekerjaan_tidak" value="Tidak" class="custom-control-input" {{ $errors->count() > 0 ? (old('membedakan_jenis_pekerjaan_ya') == 'Tidak' ? 'checked' : '' ) : '' }}>
                                    <label class="custom-control-label" for="membedakan_jenis_pekerjaan_tidak">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <b class="mr-2">c.</b>Dapat Menaikkan Gaji/Penghasilan 
                            </span>
                        </div>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="menaikkan_gaji" id="menaikkan_gaji_ya" value="Ya" class="custom-control-input" {{ $errors->count() > 0 ? (old('menaikkan_gaji_tidak') == 'Ya' ? 'checked' : '' ) : '' }}>
                                    <label class="custom-control-label" for="menaikkan_gaji_ya">Ya</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="menaikkan_gaji" id="menaikkan_gaji_tidak" value="Tidak" class="custom-control-input" {{ $errors->count() > 0 ? (old('menaikkan_gaji_tidak') == 'Tidak' ? 'checked' : '' ) : '' }}>
                                    <label class="custom-control-label" for="menaikkan_gaji_tidak">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endformgroup

            @formgroup(['name' => 'saran', 'row' => true])
                <label class="col-lg-4"><b>14.</b> Saran Perbaikan Untuk {{ kustomisasi('nama') }}</label>
                <div class="col-lg-8">
                    <textarea name="saran" class="form-control">{{ $errors->count() > 0 ? old('saran') : '' }}</textarea>
                </div>
            @endformgroup

            @formgroup(['row' => true])
                <label class="col-lg-4"></label>
                <div class="col-lg-8">
                    <button type="submit" class="btn btn-success btn-lg">Selesai</button>
                </div>
            @endformgroup
        </form>
    @endcard
@endsection