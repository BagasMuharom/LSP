<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GlobalAuth;
use Hash;
use Storage;
use App\Models\User;

class PengaturanAkunController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user,mhs');
    }
    
    /**
     * Mengubah profil pengguna
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function ubahProfil(Request $request)
    {
        $validationArr = [];

        if (GlobalAuth::getAttemptedGuard() == 'mhs') {
            $validationArr['email'] = 'required|email|unique:mahasiswa,email,' . GlobalAuth::user()->nim . ',nim';             
        }
        else {
            $validationArr['email'] = 'required|email|unique:users,email,' . GlobalAuth::user()->id;
            $validationArr['nama'] = 'required|string|min:8|max:255'; 
        }

        $this->validate($request, $validationArr);

        GlobalAuth::update($request->except('_token'));
        
        return back()->withSuccess('Berhasil mengubah profil akun !');
    }

    /**
     * Mengubah kata sandi
     *
     * @param Request $request
     * @return \Illuminate\Htt\Response
     */
    public function ubahKataSandi(Request $request)
    {
        if (!Hash::check($request->passlama, GlobalAuth::user()->password)) {
            return back()->withErrors([
                'passlama' => 'Kata sandi lama salah !'
            ]);
        }

        $this->validate($request, [
            'passlama' => 'required|min:8',
            'passbaru' => 'required|min:8|confirmed'
        ]);

        GlobalAuth::user()->update([
            'password' => Hash::make($request->passbaru)
        ]);
        
        return back()->withSuccess('Berhasil mengubah kata sandi !');
    }

    /**
     * Melakukan pengunggahan syarat oleh mahasiswa
     *
     * @param Request $request
     * @return \Illuminate\Htt\Response
     */
    public function unggahSyarat(Request $request)
    {
        $request->validate([
            'ktp' => 'nullable|image|max:1024',
            'foto' => 'nullable|image|max:1024',
            'transkrip' => 'nullable|file|mimes:pdf|max:1024'
        ]);

        $mhs = GlobalAuth::user();

        $dir = 'data/' . $mhs->nim . '/';
        
        if ($request->has('ktp')) { 
            $this->deleteFile($mhs->dir_ktp);
            $ktp = $request->file('ktp');
            $ktp->storeAs($dir, $this->generateDir($request->file('ktp'), 'ktp'));
            $mhs->dir_ktp = $dir . $this->generateDir($request->file('ktp'), 'ktp');
        }
        if ($request->has('foto')) {
            $this->deleteFile($mhs->dir_foto);
            $foto = $request->file('foto');
            $foto->storeAs($dir, $this->generateDir($request->file('foto'), 'foto'));
            $mhs->dir_foto = $dir . $this->generateDir($request->file('foto'), 'foto');
        }
        if ($request->has('transkrip')) {
            $this->deleteFile($mhs->dir_transkrip);
            $transkrip = $request->file('transkrip');
            $transkrip->storeAs($dir, $this->generateDir($request->file('transkrip'), 'transkrip'));
            $mhs->dir_transkrip = $dir . $this->generateDir($request->file('transkrip'), 'transkrip');
        }

        $mhs->save();

        return back()->with([
            'success' => 'Berhasil mengunggah berkas !'
        ]);
    }

    /**
     * Menghapus file
     *
     * @param string $dir
     * @return void
     */
    private function deleteFile($dir)
    {
        if (Storage::exists($dir)) {
            Storage::delete($dir);
        }
    }

    /**
     * Mendapatkan string berupa direktori file persyaratan
     *
     * @param mixed $file
     * @param string $name
     * @return string
     */
    private function generateDir($file, $name)
    {
        return $name . '.' . $file->getCLientOriginalExtension();
    }

    /**
     * Mengunggah berkas yang dikirim oleh user
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function unggahBerkas(Request $request)
    {
        $user = GlobalAuth::user();

        $request->file('berkas')->storeAs('data/user/' . $user->id . '/', $this->generateDir(
            $request->file('berkas'), $request->nama
        ));

        return back()->with([
            'success' => 'Berhasil mengunggah berkas !'
        ]);
    }

    /**
     * Menghapus berkas dari user tertentu
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function hapusBerkas(Request $request, User $user)
    {
        $filename = 'data/user/' . $user->id . '/' . $request->filename;

        Storage::delete($filename);

        return back()->with([
            'success' => 'Berhasil menghapus berkas !'
        ]);
    }

    /**
     * Menampilkan berkas tertentu dari user tertentu
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function lihatBerkas(User $user, $filename)
    {
        $filename = 'data/user/' . $user->id . '/' . $filename;

        $file = Storage::get($filename);

        return response($file, 200)
            ->header('Content-Type', Storage::mimeType($filename))
            ->header('Content-Length', strlen($file));
    }

}
