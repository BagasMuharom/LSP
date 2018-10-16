<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:user']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'nama' => 'required',
            'nip' => 'nullable|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => bcrypt($request->password)
        ]);

        foreach ($request->roles as $role) {
            try {
                $role = Role::findOrFail($role);
                $user->getUserRole()->save($role);
            }
            catch (ModelNotFoundException $e) {}
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah user !'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'nama' => 'required',
            'nip' => 'nullable',
            'email' => 'required|email'
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'nip' => $request->nip
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengedit user !'
        ]);
    }

    /**
     * Mereset kata sandi
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function resetKataSandi(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        $hash = bcrypt($request->password);

        $user->update([
            'password' => $hash
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah kata sandi !'
        ]);
    }

    /**
     * Mengubah daftar role user
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, User $user)
    {
        $this->authorize('update', $user);

        // menambahkan role baru
        foreach ($request->roles as $role) {
            try {
                $role = Role::findOrFail($role);

                if ($user->hasRole($role->nama))
                    continue;

                $user->getUserRole()->save($role);
            }
            catch (ModelNotFoundException $e) {}
        }

        // menghapus role
        foreach ($user->getUserRole(false) as $role) {
            if (!in_array($role->id, $request->roles)) {
                $user->getUserRole()->detach(Role::find($role->id));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengupdate role user !'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus user !',
            'redirect' => route('user')
        ]);
    }
}
