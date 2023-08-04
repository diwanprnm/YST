<?php

namespace App\Http\Controllers;
use App\Models\KategoriDonasi;
use Illuminate\Http\Request;

class KategoriDonasiController extends Controller
{
    public function getKategoriDonasi()
    {
        
        $data = KategoriDonasi::all();
        return [
            "status" => 1,
            "data" => $data
        ];
    }
    
    public function CreateKategoriDonasi(Request $request)
    {
        
        $request->validate([
            'kategori_donasi' => 'required',
            'ket_kategori_donasi' => 'required',
            
        ]);
        $data = $request->all();
       
        KategoriDonasi::create($data);
        return [
            "status" => 1,
            "data" => $data,
            "msg" => "Data Kategori Donasi created successfully"
        ];
    }
    public function updateKategoriDonasi(Request $request,$id_kat_donasi)
    {
        $request->validate([
            'kategori_donasi' => 'required',
            'ket_kategori_donasi' => 'required',
            
        ]);

        $data = KategoriDonasi::find($id_kat_donasi);
        $data->kategori_donasi = $request->kategori_donasi;
        $data->ket_kategori_donasi = $request->ket_kategori_donasi;
        
        $data->save();
       
        return response()->json([
            'message' => 'data Kategori Donasi berhasil diperbarui',
            'data' => $data
        ], 200);
       
    }
    public function deleteDonasi($id_kat_donasi)
    {
        $data = KategoriDonasi::find($id_kat_donasi);

        if ($data) {
            $data->delete();

            return response()->json([
                'message' => 'Data donasi berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'message' => 'Data donasi tidak ditemukan',
            ], 404);
        }
    }


}