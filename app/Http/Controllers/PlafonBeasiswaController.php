<?php

namespace App\Http\Controllers;
use App\Models\PlafonBeasiswa;
use Illuminate\Http\Request;

class PlafonBeasiswaController extends Controller
{
    public function getPlafonBeasiswa(Request $request)
    {
        
        $id = $request->input('id'); // Menambahkan input id_berita
            
            $query = PlafonBeasiswa::query();
            
            if ($id !== null) {
                $query->where('id', $id); // Menambahkan filter berdasarkan ID
            }
        
            $data = $query->get();
            $response = [
                "status" => 1,
                "data" => $data,
        
            ];
        
            return $response;
    
    }

    public function updatePlafonBeasiswa(Request $request,$id)
    {
        $request->validate([
            'jenjang' => 'required',
            'nominal' => 'required',
            

            
        ]);

        $data = PlafonBeasiswa::find($id);
        $data->jenjang = $request->jenjang;
        $data->nominal = $request->nominal;
        
        $data->save();
       


        return response()->json([
            'message' => 'data Plafon Beasiswa berhasil diperbarui',
            'data' => $data
        ], 200);
       
    }


    


}