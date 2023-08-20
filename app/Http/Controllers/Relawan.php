<?php

namespace App\Http\Controllers;
use App\Models\Relawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;



class RelawanController extends Controller
{
    public function getRelawan()
    {
        $relawan = Relawan::all();
        return [
            "status" => 1,
            "data" => $relawan
        ];
        
    }
    
    public function CreateRelawan(Request $request)
    {
        $request->validate([
            'domisili' => 'required',
            'nama_lengkap' => 'required',

            
        ]);
 
        $user = Auth::user();

        $relawan = $request->all();
        $relawan['id_user'] = $user->id; // Menyimpan id_user yang sedang login
        $relawan['email'] = $user->email; // Menyimpan id_user yang sedang login
        $relawan['no_hp'] = $user->no_hp; // Menyimpan id_user yang sedang login
        $relawan['status_relawan'] = 3;
        $relawan['tgl_daftar'] = now(); // Menggunakan fungsi bawaan PHP untuk mendapatkan waktu saat ini
        


        Relawan::create($relawan);
        return [
            "status" => 1,
            "data" => $relawan,
            "msg" => "relawan created successfully"
        ];
    }

    

}
