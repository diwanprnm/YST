<?php

namespace App\Http\Controllers;
use App\Models\PlafonBeasiswa;
use Illuminate\Http\Request;

class PlafonBeasiswaController extends Controller
{
    public function getPlafonBeasiswa()
    {
        
        $data = PlafonBeasiswa::all();
        return [
            "status" => 1,
            "data" => $data
        ];
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