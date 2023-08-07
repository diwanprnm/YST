<?php

namespace App\Http\Controllers;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class BeritaController extends Controller
{
    public function getBerita()
    {
        $berita = Berita::all();
        return [
            "status" => 1,
            "data" => $berita
        ];
        
    }

    public function CreateBerita(Request $request)
    {
        $request->validate([
            'judul_berita' => 'required',
            'tgl_kejadian' => 'required',
            'isi_berita' => 'required',
            'gambar_berita' => 'required',
            'kategori_berita' => 'required',
            'tgl_penulisan' => 'required',

            
        ]);
 
        $berita = $request->all();
        $berita['status_berita'] = 2;
        if ($request->file('gambar_berita')) {
            $file = $request->file('gambar_berita');

            $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $tujuan_upload = 'Foto/Berita';
            $file->move($tujuan_upload, $nama_file);
            $data['gambar_berita'] = $tujuan_upload . '/' . $nama_file;
        }
       
        Berita::create($berita);
        return [
            "status" => 1,
            "data" => $berita,
            "msg" => "Tim created successfully"
        ];
    }

    public function UpdateBerita(Request $request, $id_berita)
    {
        
        $request->validate([
            'judul_berita' => 'required',
            'tgl_kejadian' => 'required',
            'isi_berita' => 'required',
            'gambar_berita' => 'required',
            'kategori_berita' => 'required',
            'tgl_penulisan' => 'required',   
        ]);

            $berita = Berita::find($id_berita);
            $berita->judul_berita = $request->judul_berita;
            $berita->tgl_kejadian = $request->tgl_kejadian;
            $berita->isi_berita = $request->isi_berita;
            $berita->gambar_berita = $request->gambar_berita;
            $berita->kategori_berita = $request->kategori_berita;
            $berita->tgl_penulisan  = $request->tgl_penulisan ;
            $berita->save();
       


        return response()->json([
            'message' => 'Berita berhasil diperbarui',
            'data' => $berita
        ], 200);
    }
    



    public function deleteBerita($id_berita)
    {
        $berita = Berita::find($id_berita);

        if ($berita) {
            $berita->delete();

            return response()->json([
                'message' => 'Berita berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'message' => 'Berita tidak ditemukan',
            ], 404);
        }
    }

}
