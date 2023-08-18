<?php

namespace App\Http\Controllers;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ProgramDonasiController extends Controller
{
    public function getProgramDonasi(){
        $program_donasi = ProgramDonasi::all();
        return [
            "status" => 1,
            "data" => $program_donasi
        ];
    }

    public function getProgramDonasiById($id)
{
    $program_donasi = ProgramDonasi::find($id);

    if (!$program_donasi) {
        return [
            "status" => 0,
            "message" => "Program Donasi tidak ditemukan."
        ];
    }

    return [
        "status" => 1,
        "data" => $program_donasi
    ];
}



    public function createProgramDonasi(Request $request)
    {
        
        $request->validate([
            'nama_program_donasi' => 'required',
            'deskripsi_singkat_donasi' => 'required',
            'target_dana' => 'required',
            'deskripsi_lengkap_donasi' => 'required',
            'tgl_selesai' => 'required',
            'status_program_donasi' => 'required',
            'penanggung_jawab' => 'required',
            'jangka_waktu' => 'required',
            'kategori_donasi' => 'required',
            'penerima_donasi' => 'required',
            
            

            
        ]);
        $data = $request->all();
        if ($request->file('foto_p_donasi')) {
            $file = $request->file('foto_p_donasi');

            $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $tujuan_upload = 'Foto/Programdonasi';
            $file->move($tujuan_upload, $nama_file);
            $data['foto_p_donasi'] = $tujuan_upload . '/' . $nama_file;
        }
        ProgramDonasi::create($data);
        return [
            "status" => 1,
            "data" => $data,
            "msg" => "Data Program Donasi created successfully"
        ];
    }

        public function updateProgramDonasi(Request $request,$id_program_donasi)
        {
            $request->validate([
                'nama_program_donasi' => 'required',
                'deskripsi_singkat_donasi' => 'required',
                'target_dana' => 'required',
                'deskripsi_lengkap_donasi' => 'required',
                'tgl_selesai' => 'required',
                'penanggung_jawab' => 'required',
                'jangka_waktu' => 'required',
                'kategori_donasi' => 'required',
                'penerima_donasi' => 'required',
                
                
            ]);
    
            $data = ProgramDonasi::find($id_program_donasi);
            $data->nama_program_donasi = $request->nama_program_donasi;
            $data->deskripsi_lengkap_donasi = $request->deskripsi_lengkap_donasi;
            $data->deskripsi_singkat_donasi = $request->deskripsi_singkat_donasi;
            $data->target_dana = $request->target_dana;
            $data->tgl_selesai = $request->tgl_selesai;
            $data->penanggung_jawab = $request->penanggung_jawab;
            $data->jangka_waktu = $request->jangka_waktu;
            $data->penerima_donasi = $request->penerima_donasi;
            $data->kategori_donasi = $request->kategori_donasi;
           
            $data->save();
           
            return response()->json([
                'message' => 'data Beasiswa berhasil diperbarui',
                'data' => $data
            ], 200);
           
        }


        public function deleteProgramDonasi($id_program_donasi)
        {
            $programDonasi = ProgramDonasi::find($id_program_donasi);
    
            if ($programDonasi) {
                $programDonasi->delete();
    
                return response()->json([
                    'message' => 'program Donasi berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'message' => 'programDonasi tidak ditemukan',
                ], 404);
            }
        }



}
