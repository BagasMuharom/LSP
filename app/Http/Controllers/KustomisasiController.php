<?php

namespace App\Http\Controllers;

use App\Models\Kustomisasi;
use App\Support\Facades\GlobalAuth;
use Illuminate\Http\Request;

class KustomisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:kustomisasi']);
    }

    public function update(Kustomisasi $kustomisasi, Request $request)
    {
        $this->validate($request, ['value' => 'required']);

        $kustomisasi->value = $request->value;
        $kustomisasi->user_id = GlobalAuth::user()->id;
        $kustomisasi->save();

        return back()->with('success', 'Berhasil memperbarui data');
    }

    public function updateFile(Kustomisasi $kustomisasi, Request $request)
    {
        $request->file('value')->move('images/kustomisasi', $kustomisasi->key.'.'.$request->file('value')->getClientOriginalExtension());
        $kustomisasi->value = 'images/kustomisasi/'.$kustomisasi->key.'.'.$request->file('value')->getClientOriginalExtension();
        $kustomisasi->user_id = GlobalAuth::user()->id;
        $kustomisasi->save();

        return back()->with('success', 'Berhasil memperbarui data');
    }
}
