<?php

namespace App\Http\Controllers;
use App\Models\ProgramRelawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ProgramRelawanController extends Controller
{
    public function getProgramRelawan(){
        $program_relawan = ProgramRelawan::all();
        return [
            "status" => 1,
            "data" => $program_relawan
        ];
    }

    public function createProgramRelawan(Request $request)
    {
        
        $request->validate([
            'nama_program_relawan' => 'required',
            'deskripsi_singkat_relawan' => 'required',
            'target_relawan' => 'required',
            'deskripsi_lengkap_relawan' => 'required',
            'tgl_pelaksanaan' => 'required',
            'status_program_relawan' => 'required',
            'penanggung_jawab' => 'required',
            'tenggat_waktu' => 'required',
            'lokasi_awal' => 'required',
            'kategori_relawan' => 'required',
            'lokasi_program' => 'required',
                
        ]);
        $data = $request->all();
        if ($request->file('foto_p_relawan')) {
            $file = $request->file('foto_p_relawan');

            $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $tujuan_upload = 'Foto/Programrelawan';
            $file->move($tujuan_upload, $nama_file);
            $data['foto_p_relawan'] = $tujuan_upload . '/' . $nama_file;
        }
        ProgramRelawan::create($data);
        return [
            "status" => 1,
            "data" => $data,
            "msg" => "Data Program relawan created successfully"
        ];
    }

        public function updateProgramRelawan(Request $request,$id_program_relawan)
        {
            $request->validate([
                'nama_program_relawan' => 'required',
                'deskripsi_singkat_relawan' => 'required',
                'tenggat_waktu' => 'required',
                'deskripsi_lengkap_relawan' => 'required',
                'tgl_pelaksanaan' => 'required',
                'penanggung_jawab' => 'required',
                'tenggat_waktu' => 'required',
                'kategori_relawan' => 'required',
                'lokasi_awal' => 'required',

                
                
            ]);
    
            $data = ProgramRelawan::find($id_program_relawan);
            $data->nama_program_relawan = $request->nama_program_relawan;
            $data->deskripsi_lengkap_relawan = $request->deskripsi_lengkap_relawan;
            $data->deskripsi_singkat_relawan = $request->deskripsi_singkat_relawan;
            $data->tenggat_waktu = $request->tenggat_waktu;
            $data->lokasi_awal = $request->lokasi_awal;
            $data->tgl_pelaksanaan = $request->tgl_pelaksanaan;
            $data->penanggung_jawab = $request->penanggung_jawab;
            $data->tenggat_waktu = $request->tenggat_waktu;
            $data->kategori_relawan = $request->kategori_relawan;
           
            $data->save();
           
            return response()->json([
                'message' => 'data Program Relawan berhasil diperbarui',
                'data' => $data
            ], 200);
           
        }


        public function deleteProgramRelawan($id_program_relawan)
        {
            $programrelawan = Programrelawan::find($id_program_relawan);
    
            if ($programrelawan) {
                $programrelawan->delete();
    
                return response()->json([
                    'message' => 'program relawan berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'message' => 'programrelawan tidak ditemukan',
                ], 404);
            }
        }



}
