<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Facades\GlobalAuth;

class TTDController extends Controller
{
    
    /**
     * Menambah TTD baru
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $user = GlobalAuth::user();

        $user->getTTD()->create([
            'ttd' => $request->ttd
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan tanda tangan !'
        ]);
    }
    
    /**
     * Menghapus TTD
     *
     * @param integer $id
     * @return void
     */
    public function destroy($id)
    {
        GlobalAuth::user()->getTTD()->where('id', $id)->delete();

        return back()->with([
            'success' => true,
            'message' => 'Berhasil menghapus tanda tangan !'
        ]);
    }

}
