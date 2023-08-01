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

    public function UpdateBerita(Request $request,$id_berita)
    {
        $berita = Berita::find($id_berita);
        if ($berita) {
        // Update status_berita menjadi 1
        $berita->update(['status_berita' => 1]);

        return response()->json([
            'message' => 'Status berita berhasil diupdate menjadi 1',
            'data' => $berita
        ]);
         } else {
        return response()->json([
            'message' => 'Berita tidak ditemukan',
        ], 404);
    }

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
