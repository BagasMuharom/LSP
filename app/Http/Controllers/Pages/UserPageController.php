<?php

namespace App\Http\Controllers\Pages;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;

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
    public function index(Request $request)
    {
        $daftarUser = User::query();

        $daftarUser->when($request->has('keyword'), function ($query) use ($request) {
            $query->where('nama', 'ILIKE', '%' . $request->keyword . '%');
        });

        return view('menu.user.index', [
            'daftarUser' => $daftarUser->paginate(20),
            'colorlist' => [
                'primary', 'warning', 'danger', 'success'
            ],
            'total' => $daftarUser->paginate(20)->count()
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
        $daftarBerkas = Storage::files('data/user/' . $user->id);

        return view('menu.user.detail', [
            'user' => $user,
            'daftarRole' => $user->getUserRole(false),
            'daftarBerkas' => $daftarBerkas,
            'roles' => Role::all(),
            'menu' => Menu::findByRoute(Menu::USER)
        ]);
    }

}
