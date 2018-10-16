<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\Skema;

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

}
