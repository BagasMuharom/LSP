<?php

namespace App\Http\Controllers\Pages;

use App\Models\Dana;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DanaPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:dana'
        ]);
    }

    public function index()
    {
        return view('menu.dana.index', [
            'data' => Dana::orderBy('id')->paginate(10),
            'menu' => Menu::findByRoute(Menu::DANA)
        ]);
    }
}
