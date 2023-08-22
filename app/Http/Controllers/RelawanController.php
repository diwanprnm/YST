<?php

namespace App\Http\Controllers;
use App\Models\Relawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;



class RelawanController extends Controller
{
    public function getRelawan(Request $request)
    {
    $status = $request->input('status_relawan');

    $query = Relawan::query();

    if ($status !== null) {
        $query->where('status_relawan', $status);
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

    public function approveRelawan(Request $request, $id)
    {
        $relawan = Relawan::find($id);

        if (!$relawan) {
            return [
                "status" => 0,
                "msg" => "relawan not found"
            ];
        }

        $relawan->status_relawan = 1;
        $relawan->save();

        return [
            "status" => 1,
            "msg" => "relawan approved Berhasil"
        ];
    }
    public function rejectRelawan(Request $request, $id)
    {
        $relawan = Relawan::find($id);

        if (!$relawan) {
            return [
                "status" => 0,
                "msg" => "relawan not found"
            ];
        }

        $relawan->status_relawan = 2;
        $relawan->save();

        return [
            "status" => 1,
            "msg" => "relawan reject Berhasil"
        ];
    }


}
