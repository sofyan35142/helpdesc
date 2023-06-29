<?php

namespace App\Http\Controllers\Api;

use Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class UserController extends Controller
{
    public function index()
    {
        // return "p";
        return User::select('id', 'name', 'email', 'level')->get();
    }
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'level' => $request->level,
            ]);

            return response()->json([
                'message' => "User berhasil dibuat"
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Ada yang salah saat membuat user coba ulangi lagi!!!'
            ], 500);
        }
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'user' => $user
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'level' => 'required'
        ]);
        try {
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'level' => $request->level
            ])->update();
            return response()->json([
                'message' => 'User berhasil di update'
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
    public function destroy($id)
    {
        $user = user::find($id);
        try {
            $user->delete();
            return response()->json([
                'message' => "Data user berhasil dihapus!!!"
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                "message" => 'terjadi kesalahan coba ulangi lagi!!'
            ]);
        }
    }
}
