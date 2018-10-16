<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:menu']);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'nama' => 'required'
        ]);

        try{
            $menu = Menu::findOrFail(decrypt($request->id));
            $menu->nama = $request->nama;
            $menu->icon = $request->icon;
            $menu->save();

            return back()->with('success', 'Berhasil memperbarui data');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('success', 'Data tidak ditemukan');
        }
        catch (QueryException $exception){
            return back()->with('error', 'Duplikasi nama menu<br>'.$exception->getMessage());
        }
    }
}
