<?php

namespace App\Http\Controllers\Pages;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;

class UserPageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daftarUser = User::query();

        return view('menu.user.index', [
            'daftarUser' => $daftarUser->paginate(20),
            'colorlist' => [
                'primary', 'warning', 'danger', 'success'
            ],
            'total' => $daftarUser->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('menu.user.tambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('menu.user.detail', [
            'user' => $user,
            'daftarRole' => $user->getUserRole(false),
            'roles' => Role::all(),
            'menu' => Menu::findByRoute(Menu::USER)
        ]);
    }

}
