<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:role']);
    }

    public function updateMenu(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        try{
            $role = Role::findOrFail(decrypt($request->id));
            $role->getRoleMenu()->detach();

            try{
                foreach (Menu::whereIn('id', array_keys($request->menu))->get() as $menu){
                    $role->getRoleMenu()->attach($menu);
                }
            } catch (\ErrorException $exception){

            }

            if ($role->nama == Role::SUPER_ADMIN && !$role->hasMenu(Menu::ROLE)){
                $role->getRoleMenu()->attach(Menu::findByRoute(Menu::ROLE));
            }

            return back()->with('success', 'Berhasil memperbarui hak akses <b>'.$role->nama.'</b>');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'nama' => 'required'
        ]);

        try{
            $role = Role::findOrFail(decrypt($request->id));
            $role->nama = $request->nama;
            $role->save();

            return back()->with('success', 'Berhasil memperbarui hak akses <b>'.$role->nama.'</b>');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        try{
            $role = Role::findOrFail(decrypt($request->id));
            $role->delete();

            return back()->with('success', 'Berhasil menghapus hak akses <b>'.$role->nama.'</b>');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        try{
            $role = Role::create([
                'nama' => $request->nama
            ]);

            try{
                foreach (Menu::whereIn('id', array_keys($request->menu))->get() as $menu){
                    $role->getRoleMenu()->attach($menu);
                }
            }
            catch (\ErrorException $exception){

            }

            return back()->with('success', 'Berhasil menambah hak akses <b>'.$role->nama.'</b>');
        }
        catch (QueryException $exception){
            return back()->with('error', 'Terdapat duplikasi data<br>'.$exception->getMessage());
        }
    }
}
