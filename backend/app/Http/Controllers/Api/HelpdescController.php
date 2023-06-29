<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\helpdesk;
use Mockery\Expectation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HelpdescController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return helpdesk::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'keluhan' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required'
        ]);
        $img_name = "";
        if ($request->hasFile('foto')) {
            $img = $request->file('foto');
            $img_name = $img->getClientOriginalName();
            $img->move(public_path('image'),$img_name);
        }
        try {
            helpdesk::create([
                "id_user" => auth()->user()->id,
                "keluhan" => $request->keluhan,
                "deskripsi" => $request->deskripsi,
                "link_img" => url('/image/'),
                "foto" => $img_name,
            ]);
            return response()->json(["message"=>"Keluhan berhasil diupload!!"]);
        } catch (Exception $e) {
            return response()->json(['message' => "Terjadi kesalahan :" . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = helpdesk::findorfail($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'keluhan' => 'required',
            'deskripsi' => 'required',
        ]);
        $data = helpdesk::findorfail($id);
        $img_name = $data->foto;
        if ($request->hasFile('foto')) {
            $img = $request->file('foto');
            $img_name = $img->getClientOriginalName();
            $img->move(public_path('image'),$img_name);
        }
        try {
            $data->update([
                // "id_user" => auth()->user()->id,
                "keluhan" => $request->keluhan,
                "deskripsi" => $request->deskripsi,
                "link_img" => url("/image/"),
                "foto" => $img_name,
            ]);
            return response()->json(["message"=>"Keluhan berhasil diupdate!!"]);
        } catch (Exception $e) {
            return response()->json(['message' => "Terjadi kesalahan :" . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data  = helpdesk::findorfail($id);
        $image_path = public_path("image/{$data->foto}");
        if (File::exists($image_path)) {
            unlink($image_path);
        }
        try {
            $data->delete();
            return response()->json(["message"=>'Data berhasil dihapus!!!']);
        } catch (\Exception $th) {
            return response()->json(["message"=>"terjadi kesalahan: ".$th->getMessage()],500);
        }
    }
}
