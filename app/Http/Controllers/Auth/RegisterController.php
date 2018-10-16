<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{Mahasiswa, Prodi};
use App\Support\ApiUnesa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Validator};
use Mail;
use App\Mail\EmailVerifikasi;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'guest:mhs', 'guest:user'
        ]);
    }

    /**
     * Proses pendaftaran
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if (!$this->mahasiswaTerdaftar($request->nim)) {
            return back()->withErrors([
                'nim' => 'NIM tersebut tidak terdaftar !',
            ]);
        }

        $user = $this->create($request->all());

        // mengirim email
        try {
        Mail::to($user->email)
            ->send(new Emailverifikasi($user));
        } catch (\Exception $err) {
            return back()->with([
                'success' => 'Berhasil melakukan pendaftaran. Namun kami gagal mengirim email verifikasi, mohon melakukan verifikasi manual melalui admin/staff LSP UNESA !',
            ]);
        }

        return back()->with([
            'success' => 'Berhasil melakukan pendaftaran. Silahkan cek email untuk verifikasi akun !',
        ]);
    }

    /**
     * Mengecek apakah nim terkait terdaftar pada database Unesa
     *
     * @param string $nim
     * @return boolean
     */
    private function mahasiswaTerdaftar($nim)
    {
        $this->mhs = ApiUnesa::getDetailMahasiswa($nim);

        return !is_null($this->mhs);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nim' => 'required|numeric|digits:11',
            'nik' => 'required|numeric|digits:16',
            'email' => 'required|string|email|max:255|unique:mahasiswa',
            'password' => 'required|string|min:6|confirmed',
            'no_telepon' => [
                'required',
                'regex:/(\+|0)[0-9]*/'
            ]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $prodi = Prodi::where('nama', $this->mhs->prodi)->first();

        return Mahasiswa::create([
            'nim' => $data['nim'],
            'nik' => $data['nik'],
            'nama' => $this->mhs->nama_mahasiswa,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'prodi_id' => $prodi->id,
            'no_telepon' => $data['no_telepon'],
            'alamat' => $this->mhs->jln,
            'jenis_kelamin' => $this->mhs->jenis_kelamin,
            'pendidikan' => 'SMA atau sederajat',
            'pekerjaan' => 'Mahasiswa/pelajar',
            'kabupaten' => $this->mhs->nama_wilayah->nm_kab,
            'provinsi' => $this->mhs->nama_wilayah->nm_prop,
            'tgl_lahir' => Carbon::parse($this->mhs->tgl_lahir),
            'tempat_lahir' => $this->mhs->tempat_lahir
        ]);
    }
}
