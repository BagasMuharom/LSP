<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\Skema;
use Illuminate\Support\Facades\Storage;

class AsesorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware('menu:asesor');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $asesor)
    {
        foreach ($request->input('skema') as $skema) {
            try {
                $skema = Skema::findOrFail($skema);
                $sudahpunya = $asesor->getAsesorSkema()->where('id', $skema->id)->count() > 0;

                if ($sudahpunya)
                    continue;

                $asesor->getAsesorSkema()->attach($skema);
            }
            catch (ModelNotFoundException $err) {
                //
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengedit daftar skema !'
        ]);
    }

    /**
     * Mengunggah surat tugas
     *
     * @param Request $request
     * @param User $asesor
     * @return \Illuminate\Http\Response
     */
    public function unggahBerkas(Request $request, User $asesor)
    {
        $request->validate([
            'judul' => 'required|string',
            'berkas' => 'required|file'
        ]);

        $request->file('berkas')->storeAs(
            'data/berkas/' . $asesor->id . '/',  
            $request->judul . '.' . $request->file('berkas')->getClientOriginalExtension()
        );

        return back()->with([
            'success' => 'Berhasil mengunggah berkas !'
        ]);
    }

    /**
     * Menghapus surat tugas
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function hapusBerkas(Request $request)
    {
        try {
            $asesor = User::findOrFail($request->asesor);
            $dir = $request->dir;

            Storage::delete('data/berkas/' . $asesor->id . '/' . $dir);

            return back()->with([
                'success' => 'Berhasil menghapus berkas !'
            ]);
        }
        catch (ModelNotFoundException $err) {
            abort(404);
        }
    }

    /**
     * Melihat surat tugas
     *
     * @param Request $request
     * @param User $asesor
     * @param string $dir
     * @return \Illuminate\Http\Response
     */
    public function lihatBerkas(User $asesor, $dir)
    {
        $filename = decrypt($dir);
        $filename = 'data/berkas/' . $asesor->id . '/' . $filename;

        $file = Storage::get($filename);

        return response($file, 200)
            ->header('Content-Type', Storage::mimeType($filename))
            ->header('Content-Length', strlen($file));
    }

}
