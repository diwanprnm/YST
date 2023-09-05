<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        // Menerapkan middleware 'auth:sanctum' hanya pada beberapa fungsi
        $this->middleware('auth:sanctum')->only(['getUserAktif', 'updateUser','deleteUser']);
    }


    public function getUserAktif()
    {
        
        $user = User::where('status_user' ,'y')->get();
        $totalData = $user->count();

        return [
            "status" => 1,
            "total_data" => $totalData,
            "data" => $user
        ];
    }

    public function updateUser(Request $request,  $id)
    {

       

        $request->validate([
            'no_hp' => 'required',
            'jenis_kelamin' => 'required',
            'file_keluarga' => 'required',
            'nik' => 'required',
            'username' => 'required',
            'level_user' => 'required',
            'wilayah_id' => 'required',
            'email' => 'required',
            
        ]);
        
        $user = User::find($id);
        $user->nik = $request->nik;
        $user->nama = $request->nama;
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;
        $user->level_user = $request->level_user;
        $user->username = $request->username;
        $user->file_keluarga = $request->file_keluarga;
        $user->save(); 
        return [
            "status" => 1,
            "data" => $user,
            "msg" => "user updated successfully"
        ];
    }
    

    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();

            return response()->json([
                'message' => 'user berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'message' => 'user tidak ditemukan',
            ], 404);
        }
    }






    
}


