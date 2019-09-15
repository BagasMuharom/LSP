<?php

// Autentikasi
Auth::routes();

Route::namespace('Pages')->group(function () {

    // Alamat email terverifikasi
    Route::get('verifikasi/email/{token}', [
        'uses' => 'MahasiswaPageController@terverifikasi',
        'as' => 'verifikasi.email'
    ]);

    // Halaman dashboard
    Route::get('dashboard', 'DashboardPageController')->name('dashboard');

    // Halaman jika akun belum terverifikasi
    Route::get('belum-terverifikasi', [
        'uses' => 'MahasiswaPageController@belumTerverifikasi',
        'as' => 'mahasiswa.belum_terverifikasi'
    ]);

    // Menampilkan halaman pengaturan akun
    Route::get('pengaturan-akun',[
        'uses' => 'PengaturanPageController',
        'as' => 'pengaturan.akun'
    ]);

});

// mengirim ulang token verifikasi
Route::post('verifikasi/kirim-ulang', [
    'uses' => 'MahasiswaController@kirimUlangverifikasi',
    'as' => 'email.kirim.ulang'
]);

Route::namespace('Auth')->group(function () {

    Route::get('reset-kata-sandi', [
        'uses' => 'ForgotPasswordController@halamanResetKataSandi',
        'as' => 'reset.kata.sandi'
    ]);

    // reset kata sandi
    Route::post('reset-kata-sandi', [
        'uses' => 'ForgotPasswordController@kirimKataSandi',
        'as' => 'reset.kata.sandi'
    ]);

});

// proses pengunggahan syarat untuk mahasiswa
Route::post('unggah/syarat', [
    'uses' => 'PengaturanAkunController@unggahSyarat',
    'as' => 'mahasiswa.unggah.syarat'
]);

Route::get('lihat/syarat/{jenis}/{mahasiswa}', [
    'uses' => 'MahasiswaController@lihatSyarat',
    'as' => 'lihat.syarat'
]);

// Proses pengaturan akun
Route::post('pengaturan-akun',[
    'uses' => 'PengaturanAkunController@ubahProfil',
    'as' => 'pengaturan.akun'
]);

// Proses mengubah kata sandi
Route::post('ubahkatasandi', [
    'uses' => 'PengaturanAkunController@ubahKataSandi',
    'as' => 'ubah.kata.sandi'
]);

Route::post('tambah-ttd', [
    'uses' => 'TTDController@store',
    'as' => 'ttd.tambah'
]);

Route::post('hapus-ttd/{id}', [
    'uses' => 'TTDController@destroy',
    'as' => 'ttd.hapus'
]);

// Mengelola berkas dari user tertentu
Route::prefix('berkas')->group(function () {

    Route::post('unggah', [
        'uses' => 'PengaturanAkunController@unggahBerkas',
        'as' => 'user.berkas.unggah'
    ]);
    
    Route::delete('hapus/{user}', [
        'uses' => 'PengaturanAkunController@hapusBerkas',
        'as' => 'user.berkas.hapus'
    ]);

    Route::get('lihat/{user}/{filename}', [
        'uses' => 'PengaturanAkunController@lihatBerkas',
        'as' => 'user.berkas.lihat'
    ]);

});

// Mendapatkan daftar syarat dari skema tertentu
Route::post('skema/daftar-syarat', [
    'uses' => 'SkemaController@getDaftarSyarat',
    'as' => 'skema.daftar_syarat'
]);

Route::post('fakultas/daftar/jurusan/{fakultas}', [
    'uses' => 'FakultasController@getDaftarJurusan',
    'as' => 'fakultas.daftar.jurusan'
]);

Route::post('jurusan/daftar/prodi/{jurusan}', [
    'uses' => 'JurusanController@getDaftarProdi',
    'as' => 'jurusan.daftar.prodi'
]);

Route::get('test/FR.AI.04', function () {
    return view('form.fr_ai_04');
});

Route::get('test/fr_ai_05', function () {
    return view('form.fr_ai_05');
});

Route::get('test/fr_ac_01', function () {
    return view('form.fr_ac_01');
});