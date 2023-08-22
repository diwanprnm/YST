<?php

namespace App\Http\Controllers;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;



class DonasiController extends Controller
{
    public function getDonasi(Request $request)
    {
    $status = $request->input('status_donasi');

    $query = Donasi::query();

    if ($status !== null) {
        $query->where('status_donasi', $status);
    }

    $data = $query->get();

    if ($status !== null) {
        return [
            "status" => 1,
            "filtered_data" => $data
        ];
    } else {
        return [
            "status" => 1,
            "data" => $data
        ];
    }
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
        $donasi['belum_dibayar'] = $nominalDonasi + rand(100, 999); // Menambahkan 3 angka acak

        $donasi['tgl_donasi'] = now(); // Menggunakan fungsi bawaan PHP untuk mendapatkan waktu saat ini



        Donasi::create($donasi);
        return [
            "status" => 1,
            "data" => $donasi,
            "msg" => "donasi created successfully"
        ];
    }

    public function approveDonasi(Request $request, $id)
    {
        $donasi = Donasi::find($id);

        if (!$donasi) {
            return [
                "status" => 0,
                "msg" => "Donasi not found"
            ];
        }

        $donasi->status_donasi = 1;
        $donasi->save();

        return [
            "status" => 1,
            "msg" => "Donasi reject Berhasil"
        ];
    }
}


