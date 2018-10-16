<?php

namespace App\Http\Controllers;

use App\Models\Dana;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DanaController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:dana'
        ]);
    }

    public function update(Request $request, Dana $dana)
    {
        $dana->nama = $request->nama;
        $dana->berulang = ($request->berulang == 'true');
        $dana->keterangan = $request->keterangan;
        $dana->save();

        return back()->with('success', 'Berhasil memperbarui data');
    }

    public function add(Request $request)
    {
        try{
            $dana = Dana::create([
                'nama' => $request->nama,
                'berulang' => (empty($request->berulang) ? false : true),
                'keterangan' => $request->keterangan
            ]);

            return back()->with('success', 'Berhasil menambahkan dana <b>'.$dana->nama.'</b>');
        }
        catch (QueryException $exception){
            return back()->with('error', 'Duplikasi nama dana <br>'.$exception->getMessage());
        }
    }
}
