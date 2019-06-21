<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Mahasiswa, Event};
use App\Mail\{EmailVerifikasi, ResetKataSandi};
use Storage;
use GlobalAuth;
use Mail;

class MahasiswaController extends Controller
{

    private $userPages = [
        'blokir', 'resetKataSandi', 'aktifkan', 'update', 'create', 'destroy', 'tambahEventMandiri', 'hapusEventMandiri', 'verifikasiAkun'
    ];

    private $mahasiswaPages = [
        'kirimUlangverifikasi'
    ];

    private $bothPages = [
        'lihatSyarat'
    ];

    public function __construct()
    {
        $this->middleware('auth:user,mhs')->only($this->bothPages);
        $this->middleware('auth:user')->only($this->userPages);
        $this->middleware('auth:mhs')->only($this->mahasiswaPages);
    }

    /**
     * Melihat berkas ktp, foto, atau transkrip
     *
     * @param Mahasiswa $mahasiswa
     * @return void
     */
    public function lihatSyarat($jenis, Mahasiswa $mahasiswa)
    {
        GlobalAuth::authorize('lihatSyarat', $mahasiswa);

        if (!in_array($jenis, ['ktp', 'foto', 'transkrip']))
            return abort(404);
            
        $field = 'dir_' . $jenis;
        $berkas = Storage::get($mahasiswa->{$field});

        return response($berkas, 200)
            ->header('Content-Type', Storage::mimeType($mahasiswa->{$field}))
            ->header('Content-Length', strlen($berkas));
    }

    /**
     * Proses blokir
     *
     * @param Request $request
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function blokir(Request $request, Mahasiswa $mahasiswa)
    {
        GlobalAuth::authorize('blokir', $mahasiswa);
        
        $mahasiswa->update([
            'terblokir' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memblokir akun !'
        ]);
    }

    /**
     * Melakukan reset kata sandi untuk mahasiswa tertentu oleh admin
     *
     * @param Request $request
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function resetKataSandi(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        $hash = bcrypt($request->password);

        $mahasiswa->update([
            'password' => $hash
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah kata sandi !'
        ]);
    }

    /**
     * Melakukan reset kata sandi oleh mahasiswa itu sendiri
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function resetKataSandiOlehUser(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        $user = Mahasiswa::where('email', $request->email)->first();

        if (is_null($user))
            $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan !'
            ]);
        }

        try {
            $password = bcrypt(strtoupper(str_random(8)));

            Mail::to($user->email)->send(new ResetKataSandi($password));

            $user->update([
                'password' => $password
            ]);
        }
        catch (\Exception $e) {
            return back()->with([
                'error' => 'Gagal mengirim kata sandi melalui email. Coba beberapa saat lagi. Jika masalah ini tetap terjadi, mohon hubungi admin untuk mereset secara manual'
            ]);
        }

        return back()->with([
            'success' => 'Berhasil mereset kata sandi, mohon cek email anda.'
        ]);
    }

    /**
     * Proses mengktifkan akun mahasiswa
     *
     * @param Request $request
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function aktifkan(Request $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update([
            'terblokir' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengaktifkan akun !'
        ]);
    }

    /**
     * Proses edit
     *
     * @param Request $request
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required|string|min:3',
            'nim' => 'required|max:11',
            'email' => 'required|string|email|unique:mahasiswa,email,' . $mahasiswa->nim . ',nim',
            'prodi' => 'required|numeric|exists:prodi,id',
            'nik' => 'required|numeric|digits:16|unique:mahasiswa,nik,' . $mahasiswa->nim . ',nim',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'jenis_kelamin' => 'required|string'
        ]);

        $mahasiswa->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'prodi_id' => $request->prodi,
            'nik' => $request->nik,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan' => $request->pendidikan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan data mahasiswa !'
        ]);
    }

    /**
     * Menambah mahasiswa baru
     *
     * @param Request $request
     * @return \Illuminate\Http\response
     */
    public function create(Request $request)
    {
        GlobalAuth::authorize('create', Mahasiswa::class);

        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'nama' => 'required|string',
            'nim' => 'required|numeric|digits:11|unique:mahasiswa',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:mahasiswa',
            'tempat_lahir' => 'required|string',
            'tgl_lahir' => 'required|date',
            'no_telepon' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
            'prodi_id' => 'required|exists:prodi,id',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string'
        ]);

        // pre input
        $request->password = bcrypt($request->password);

        $data = $request->except('_token');
        $data['terverifikasi'] = true;

        // menambah ke database
        Mahasiswa::create($data);

        return redirect()->route('mahasiswa')->with([
            'success' => 'Berhasil menambahkan mahasiswa baru'
        ]);
    }

    /**
     * Proses menghapus
     *
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus akun !'
        ]);
    }

    /**
     * Mengirim ulang kode verifikasi
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function kirimUlangverifikasi(Request $request)
    {
        $mahasiswa = GlobalAuth::user();
        $mahasiswa->update([
            'email' => $request->email
        ]);

        try {
            Mail::to($request->email)
                ->send(new EmailVerifikasi($mahasiswa));
        }
        catch (\Exception $e) {
            return back()->with([
                'error' => 'Gagal untuk mengirim email. Coba beberapa saat lagi. Jika masalah ini tetap terjadi, mohon hubungi admin untuk verifikasi secara menual'
            ]);
        }

        return back()->with([
            'success' => 'Berhasil mengirim kode verifikasi. Mohon untuk mengecek email'
        ]);
    }

    /**
     * Membuka event mandiri tertentu untuk mahasiswa tertentu
     *
     * @param Request $request
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function tambahEventMandiri(Request $request, Mahasiswa $mahasiswa)
    {
        $event = Event::find(decrypt($request->event));

        $event->getMahasiswaMandiriEvent()->attach($mahasiswa);

        return back()->with([
            'success' => 'Berhasil membuka event mandiri tersebut untuk mahasiswa terkait !'
        ]);
    }
    
    /**
     * Membuka event mandiri tertentu untuk mahasiswa tertentu
     *
     * @param Event $event
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function hapusEventMandiri(Event $event, Mahasiswa $mahasiswa)
    {
        $event->getMahasiswaMandiriEvent()->detach($mahasiswa);

        return back()->with([
            'success' => 'Berhasil menghapus event mandiri tersebut untuk mahasiswa terkait !'
        ]);
    }

    /**
     * Melakukan verifikasi akun
     *
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function verifikasiAkun(Mahasiswa $mahasiswa)
    {
        $mahasiswa->terverifikasi = true;
        $mahasiswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memverifikasi akun mahasiswa terkait !'
        ]);
    }

}
