<?php

namespace App\Http\Controllers;
use App\Models\KategoriRelawan;
use Illuminate\Http\Request;

class KategoriRelawanController extends Controller
{
    public function getKategoriRelawan(Request $request)
    {
        
        $id = $request->input('id_kat_relawan'); // Menambahkan input id_berita
            
        $query = KategoriRelawan::query();
        
        if ($id !== null) {
            $query->where('id_kat_relawan', $id); // Menambahkan filter berdasarkan ID
        }
    
        $data = $query->get();
        $response = [
            "status" => 1,
            "data" => $data,
    
        ];
    
        return $response;

    }
    
    public function CreateKategoriRelawan(Request $request)
    {
        
        $request->validate([
            'kategori_relawan' => 'required',
            'ket_kategori_relawan' => 'required',
            
        ]);
        $data = $request->all();
       
        KategoriRelawan::create($data);
        return [
            "status" => 1,
            "data" => $data,
            "msg" => "Data Kategori Relawan created successfully"
        ];
    }
    public function updateKategoriRelawan(Request $request,$id_kat_relawan)
    {
        $request->validate([
            'kategori_relawan' => 'required',
            'ket_kategori_relawan' => 'required',
            
        ]);

        $data = KategoriRelawan::find($id_kat_relawan);
        $data->kategori_relawan = $request->kategori_relawan;
        $data->ket_kategori_relawan = $request->ket_kategori_relawan;
        
        $data->save();
       
        return response()->json([
            'message' => 'data Kategori Relawan berhasil diperbarui',
            'data' => $data
        ], 200);
       
    }
    public function deleteKategoriRelawan($id_kat_relawan)
    {
        $data = KategoriRelawan::find($id_kat_relawan);

        if ($data) {
            $data->delete();

            return response()->json([
                'message' => 'Data relawan berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'message' => 'Data relawan tidak ditemukan',
            ], 404);
        }
    }

}