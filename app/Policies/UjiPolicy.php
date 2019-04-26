<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Uji;
use App\Models\Mahasiswa;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GlobalAuth;
use Auth;

class UjiPolicy
{
    use HandlesAuthorization;

    /**
     * Policy untuk melihat detail uji
     *
     * @param  Authenticatable  $user
     * @param  \App\Models\Uji  $uji
     * @return mixed
     */
    public function view(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa) {
            return ($uji->getMahasiswa(false)->is($user));
        }
        
        return true;
    }

    /**
     * Determine whether the user can create ujis.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(Authenticatable $user)
    {
        if ($user instanceof User)
            return false;

        foreach ($user->getUji(false) as $uji) {
            if(!in_array($uji->getStatus()['code'], [
                Uji::DITOLAK_ADMIN,
                Uji::DITOLAK_BAG_SERTIFIKASI,
                Uji::LULUS,
                Uji::TIDAK_LULUS,
                Uji::MEMILIKI_SERTIFIKAT
            ])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Mengecek apakah user terkait bisa melakukan verifikasi
     *
     * @param Authenticatable $user
     * @return boolean
     */
    public function verifikasi(Authenticatable $user)
    {
        $user = Auth::user();

        return ($user->hasRole(Role::ADMIN) || $user->hasRole(Role::SERTIFIKASI));
    }

    /**
     * Mengecek apakah user terkair bisa melakukan proses verifikais pada
     * uji tertentu
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function verifikasiTertentu(Authenticatable $user, Uji $uji)
    {
        if ($user->hasRole(Role::SUPER_ADMIN)) {
            return true;
        }
        else if ($user->hasRole(Role::ADMIN)) {
            return is_null($uji->terverifikasi_admin);
        }
        else if ($user->hasRole(Role::SERTIFIKASI)) {
            return is_null($uji->terverifikasi_bag_sertifikasi);
        }

        return false;
    }

    /**
     * Mengecek apakah user bisa melakukan verifikasi sebagai admin
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function verifikasiAsAdmin(Authenticatable $user, Uji $uji)
    {
        if (!$user->hasRole(Role::SUPER_ADMIN))
            return false;

        return is_null($uji->terverifikasi_admin) and is_null($uji->terverifikasi_bag_sertifikasi);
    }
    
    /**
     * Mengecek apakah user bisa melakukan verifikasi sebagai bag. sertifikasi
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function verifikasiAsSertifikasi(Authenticatable $user, Uji $uji)
    {
        if (!$user->hasRole(Role::SUPER_ADMIN))
            return false;

        return is_null($uji->terverifikasi_bag_sertifikasi) and !is_null($uji->terverifikasi_admin);
    }

    public function buatSertifikat(Authenticatable $user, Uji $uji)
    {
        return ($uji->isLulus() && is_null($uji->getSertifikat(false)));
    }

    /**
     * Mengecek apakah user bisa mengedit tempat uji dari uji tertentu
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function editTempatUji(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $user->hasRole(Role::SUPER_ADMIN) || $user->hasRole(Role::ADMIN);
    }

    /**
     * Mengecek apakah user bisa mengedit asesor dari uji tertentu
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function editAsesor(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $uji->getStatus()['code'] == Uji::MENGISI_ASESMEN_DIRI && ($user->hasRole(Role::SUPER_ADMIN) || $user->hasRole(Role::ADMIN));
    }

    /**
     * mengecek apakah user dapat menghapus uji
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function delete(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Mengecek apakah user terkait bisa melakukan asesmen diri
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function asesmenDiri(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof User)
            return false;

        return $uji->getMahasiswa(false)->is($user) && $uji->getStatus()['code'] == Uji::TERVERIFIKASI_BAG_SERTIFIKASI;
    }

    /**
     * Mengecek apakah asesor bisa mengisi form asesmen diri asesi
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */ 
    public function asesmenDiriAsesor(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $uji->getAsesorUji()->where('id', $user->id)->count() == 1;
    }

    /**
     * Mengecek apakah user bisa menyetak form apl-02
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function cetakFormAsesmenDiri(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $uji->hasPenilaianDiri();
    }

    /**
     * Mengecek apakah user dapat mengunduh form pendaftaran
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return void
     */
    public function cetakFormPendaftaran(Authenticatable $user, Uji $uji)
    {
        return $uji->terverifikasi_bag_sertifikasi === true;
    }

    /**
     * Mengecek apakah user dapat mengedit tanggal uji
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function editTanggalUji(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return !is_null($uji->terverifikasi_bag_sertifikasi);
    }

    /**
     * Mengecek apakah bisa menyetak form mak 02
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function cetakMak02(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $uji->konfirmasi_penilaian_asesor;
    }
    
    /**
     * Mengecek apakah bisa menyetak form mpa 02
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function cetakMpa02(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $uji->konfirmasi_penilaian_asesor;
    }

    /**
     * Mengecek apakah bisa menyetak kuesioner
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function cetakKuesioner(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $uji->hasSertifikat() && $uji->getSertifikat(false)->hasKuesioner();
    }

    /**
     * Mengecek apakah bisa mengisi kuesioner
     *
     * @param Authenticatable $user
     * @param Uji $uji
     * @return boolean
     */
    public function isiKuesioner(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof User)
            return false;

        return GlobalAuth::user()->is($user) && $uji->hasSertifikat() && !$uji->getSertifikat(false)->hasKuesioner();
    }

    /**
     * Mengecek apakah user bisa mengedit tindak lanjut asesmen
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Uji $uji
     * @return boolean
     */
    public function editTidakLanjutAsesmen(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return ($user->hasRole(Role::ADMIN) || $user->hasRole(Role::SUPER_ADMIN));
    }

    /**
     * Mengecek apakah user terkait bisa mengonfirmasi penilaian
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Uji $uji
     * @return boolean
     */
    public function konfirmasiPenilaian(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $uji->isFinished() && $uji->konfirmasi_penilaian_asesor === false;
    }

    /**
     * Mengecek apakah user terkait bisa melakukan reset penilaian
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Uji $uji
     * @return boolean
     */
    public function resetPenilaian(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return ($uji->getStatus()['code'] === Uji::PROSES_PENILAIAN) && $user->hasRole(Role::SUPER_ADMIN);
    }
    
    /**
     * Mengecek apakah user terkait bisa melakukan reset penilaian diri
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Uji $uji
     * @return boolean
     */
    public function resetPenilaianDiri(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return (in_array($uji->getStatus()['code'], [
            Uji::MENGISI_ASESMEN_DIRI,
            Uji::TIDAK_LULUS_ASESMEN_DIRI
        ])) && $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Mengecek apakah asesor bisa melakukan penilaian
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Uji $uji
     * @return void
     */
    public function penilaian(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return (($uji->getStatus()['code'] == Uji::LULUS_ASESMEN_DIRI || $uji->getStatus()['code'] == Uji::PROSES_PENILAIAN) && $uji->konfirmasi_penilaian_asesor == false);
    }

    /**
     * Mengecek apakah asesor bisa melakukan penilaian diri dari uji tertentu
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Uji $uji
     * @return boolean
     */
    public function penilaianDiri(Authenticatable $user, Uji $uji)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return (!$uji->konfirmasi_asesmen_diri);
    }

}