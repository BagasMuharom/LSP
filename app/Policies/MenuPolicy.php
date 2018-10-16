<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\Mahasiswa;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MenuPolicy
{

    use HandlesAuthorization;

    /**
     * Mengecek apakah user terkait bisa mengakses menu tertentu
     *
     * @param Authenticatable $auth
     * @param string $menu
     * @return boolean
     */
    public function view(Authenticatable $auth, Menu $menu)
    {
        if ($auth instanceof Mahasiswa)
            return false;
        
        return ($auth->hasMenu($menu));
    }
    
}
