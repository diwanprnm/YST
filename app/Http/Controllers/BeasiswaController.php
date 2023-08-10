<?php

namespace App\Http\Controllers;
use App\Models\Beasiswa;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    public function getBeasiswa(){
        $beasiswa = Beasiswa::all();
        return [
            "status" => 1,
            "data" => $beasiswa
        ];
    }

    public function CreateBeasiswa(Request $request)
    {
        
        $request->validate([
            'user_nik' => 'required',
            'tgl' => 'required',
            'nama_anak1' => 'required',
            'jenjang_pendidikan1' => 'required',
            'nama_bank1' => 'required',
            'keterangan' => 'required'

            
        ]);
        $data = $request->all();
        $data['status'] = '0';
        Beasiswa::create($data);
        return [
            "status" => 1,
            "data" => $data,
            "msg" => "Data Beasiswa created successfully"
        ];
    }

    public function updateBeasiswa(Request $request,$id_beasiswa)
    {
        $request->validate([
            'user_nik' => 'required',
            'tgl' => 'required',
            'nama_anak1' => 'required',
            'jenjang_pendidikan1' => 'required',
            'nama_bank1' => 'required',
            'keterangan' => 'required'
            
        ]);

        $data = Beasiswa::find($id_beasiswa);
        $data->user_nik = $request->user_nik;
        $data->tgl = $request->tgl;
        $data->nama_anak1 = $request->nama_anak1;
        $data->nama_anak2 = $request->nama_anak2;
        $data->nama_anak3 = $request->nama_anak3;
        $data->jenjang_pendidikan1 = $request->jenjang_pendidikan1;
        $data->jenjang_pendidikan2 = $request->jenjang_pendidikan2;
        $data->jenjang_pendidikan3 = $request->jenjang_pendidikan3;
        $data->nominal_1 = $request->nominal_1;
        $data->nominal_2 = $request->nominal_2;
        $data->nominal_3 = $request->nominal_3;
        $data->nama_bank1 = $request->nama_bank1;
        $data->nama_bank2 = $request->nama_bank2;
        $data->nama_bank3 = $request->nama_bank3;
        $data->nomor_rekening1 = $request->nomor_rekening1;
        $data->nomor_rekening2 = $request->nomor_rekening2;
        $data->nomor_rekening3 = $request->nomor_rekening3;
        $data->total_nominal = $request->total_nominal;
        $data->keterangan = $request->keterangan;
        $data->save();
       
        return response()->json([
            'message' => 'data Beasiswa berhasil diperbarui',
            'data' => $data
        ], 200);
       
    }

    public function deleteBeasiswa($id_beasiswa)
    {
        $beasiswa = Beasiswa::find($id_beasiswa);

        if ($beasiswa) {
            $beasiswa->delete();

            return response()->json([
                'message' => 'beasiswa berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'message' => 'beasiswa tidak ditemukan',
            ], 404);
        }
    }

    



}
