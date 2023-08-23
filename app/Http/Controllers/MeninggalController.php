<?php

namespace App\Http\Controllers;
use App\Models\Meninggal;
use Illuminate\Http\Request;

class MeninggalController extends Controller
{
    public function getMeninggal()
    {
        $meninggal = Meninggal::all();
        return [
        "status" => 1,
        "data" => $meninggal
    ];       
    }

    public function CreateMeninggal(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'no_kontak' => 'required',
            'nama_kontak' => 'required',
            'tgl_meninggal' => 'required',
            'tempat_pemakaman' => 'required',

            
        ]);
 
        $meninggal = $request->all();
        if ($request->file('file_surat_kematian')) {
            $file = $request->file('file_surat_kematian');

            $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $tujuan_upload = 'Foto/Berita';
            $file->move($tujuan_upload, $nama_file);
            $data['file_surat_kematian'] = $tujuan_upload . '/' . $nama_file;
        }
        if ($request->file('file_kk')) {
            $file = $request->file('file_kk');

            $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $tujuan_upload = 'Foto/Berita';
            $file->move($tujuan_upload, $nama_file);
            $data['file_kk'] = $tujuan_upload . '/' . $nama_file;
        }
        Meninggal::create($meninggal);
        return [
            "status" => 1,
            "data" => $meninggal,
            "msg" => "Data Meninggal created successfully"
        ];
    }

    public function updateMeninggal(Request $request,$id_meninggal)
    {
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'no_kontak' => 'required',
            'nama_kontak' => 'required',
            'tgl_meninggal' => 'required',
            'tempat_pemakaman' => 'required',

            
        ]);

        $meninggal = meninggal::find($id_meninggal);
        $meninggal->nik = $request->nik;
        $meninggal->nama = $request->nama;
        $meninggal->no_kontak = $request->no_kontak;
        $meninggal->tgl_meninggal = $request->tgl_meninggal;
        $meninggal->tempat_pemakaman = $request->tempat_pemakaman;
        $meninggal->tgl_penulisan = $request->tgl_penulisan;
        $meninggal->file_surat_kematian = $request->file_surat_kematian;
        $meninggal->file_kk = $request->file_kk;
        $meninggal->save();
       


        return response()->json([
            'message' => 'data meninggal berhasil diperbarui',
            'data' => $meninggal
        ], 200);
       
    }

    

    public function deleteMeninggal($id_meninggal)
    {
        $meninggal = Meninggal::find($id_meninggal);

        if ($meninggal) {
            $meninggal->delete();

            return response()->json([
                'message' => 'Data Meninggal berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'message' => 'Data Meninggal tidak ditemukan',
            ], 404);
        }
    }
}


