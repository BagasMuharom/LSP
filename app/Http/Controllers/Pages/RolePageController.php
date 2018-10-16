<?php

namespace App\Http\Controllers\Pages;

use App\Models\Menu;
use App\Models\Role;
use App\Http\Controllers\Controller;

class RolePageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:role'
        ]);
    }

    public function index()
    {
        return view('menu.role.index', [
            'menu' => Menu::findByRoute(Menu::ROLE),
            'data' => Role::orderBy('nama')->paginate(10),
            'no' => 0,
            'listmenu' => Menu::orderBy('nama')->get()
        ]);
    }
}
