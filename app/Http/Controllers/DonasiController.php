<?php

namespace App\Http\Controllers;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;



class DonasiController extends Controller
{
    public function getDonasi()
    {
        $donasi = Donasi::all();
        return [
            "status" => 1,
            "data" => $donasi
        ];
        
    }
    
    public function CreateDonasi(Request $request)
    {
        $request->validate([
            'nama_donatur' => 'required',
            'nominal_donasi' => 'required',

            
        ]);
 
        $user = Auth::user();

        $donasi = $request->all();
        $donasi['id_user'] = $user->id; // Menyimpan id_user yang sedang login
        $donasi['email'] = $user->email; // Menyimpan id_user yang sedang login
        $donasi['status_donasi'] = 2;

        $nominalDonasi = $request->input('nominal_donasi');
        $donasi['belum_dibayar'] = $nominalDonasi;

        $donasi['tgl_donasi'] = now(); // Menggunakan fungsi bawaan PHP untuk mendapatkan waktu saat ini



        Donasi::create($donasi);
        return [
            "status" => 1,
            "data" => $donasi,
            "msg" => "donasi created successfully"
        ];
    }

  

}
