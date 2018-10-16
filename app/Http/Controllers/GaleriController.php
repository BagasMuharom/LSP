<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Galeri;
use App\Support\Facades\GlobalAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GaleriController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:galeri']);
    }

    public function update(Galeri $galeri, Request $request)
    {
        if ($request->has('nama')){
            $galeri->nama = $request->nama;
            $galeri->keterangan = $request->keterangan;
            $galeri->save();
        }

        $counter = 0;
        if ($request->has('dir')){
            foreach ($request->dir as $file){
                $foto = Foto::create([
                    'galeri_id' => $galeri->id,
                    'dir' => '',
                    'keterangan' => $request->keterangan_foto
                ]);
                $file->move('images/galeri', $galeri->id.'_'.$foto->id.'_'.$file->getClientOriginalName());
                $foto->dir = 'images/galeri/'.$galeri->id.'_'.$foto->id.'_'.$file->getClientOriginalName();
                $foto->save();
                $counter++;
            }
        }

        return back()->with('success', 'Berhasil memperbarui data dan mengupload '.$counter.' foto');
    }

    public function deleteFoto(Request $request)
    {
        try{
            $foto = Foto::findOrFail(decrypt($request->id));
            if ($foto->getGaleri(false)->nama === Galeri::carousel()->nama && Galeri::carousel()->getFoto()->count() == 1){
                return back()->with('error', 'Sisakan minimal 1 foto untuk <b>'.Galeri::carousel()->nama.'</b>');
            }
            if (File::exists($foto->dir)){
                File::delete($foto->dir);
            }
            $foto->delete();

            return back()->with('success', 'Berhasil menghapus '.$foto->dir);
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'keterangan' => 'required'
        ]);

        try{
            $galeri = Galeri::create([
                'nama' => $request->nama,
                'keterangan' => $request->keterangan,
                'user_id' => GlobalAuth::user()->id
            ]);

            $counter = 0;
            if ($request->has('dir')){
                foreach ($request->dir as $file){
                    $foto = Foto::create([
                        'galeri_id' => $galeri->id,
                        'dir' => ''
                    ]);
                    $file->move('images/galeri', $galeri->id.'_'.$foto->id.'_'.$file->getClientOriginalName());
                    $foto->dir = 'images/galeri/'.$galeri->id.'_'.$foto->id.'_'.$file->getClientOriginalName();
                    $foto->save();
                    $counter++;
                }
            }

            return back()->with('success', 'Berhasil menambah galeri <b>'.$galeri->nama.'</b> dan mengupload '.$counter.' foto');
        }
        catch (QueryException $exception){
            return back()->with('error', 'Terdapat nama galeri yang sama<br>'.$exception->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try{
            $galeri = Galeri::findOrFail(decrypt($request->id));

            $counter = 0;
            foreach ($galeri->getFoto(false) as $foto){
                if (File::exists($foto->dir)){
                    File::delete($foto->dir);
                }
                $foto->delete();
                $counter++;
            }

            $galeri->delete();

            return back()->with('success', 'Berhasil menghapus galeri <b>'.$galeri->nama.'</b> beserta <b>'.$counter.' fotonya</b>');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }
}
