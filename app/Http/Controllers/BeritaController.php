<?php

namespace App\Http\Controllers;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class BeritaController extends Controller
{
    public function getBerita()
    {
        $berita = Berita::where('kategori_berita' ,'1')->get();
        $responseData = $berita->map(function ($item) {
            $item['gambar_berita'] = asset('foto/berita/' . $item['gambar_berita']); // Ganti path dengan path sesuai dengan penyimpanan foto
            return $item;
        });
        return [
            "status" => 1,
            "data" => $responseData
        ];
        
    }

     public function getArtikel(Request $request)
{
    $status = $request->input('status_berita');

    $query = Berita::query();

    if ($status !== null) {
        $query->where('status_berita', $status);
    }

    $data = $query->get();

    $totalStatus1 = $data->where('status_berita', 1)->count();
    $totalStatus2 = $data->where('status_berita', 2)->count();

    $response = [
        "status" => 1,
        "filtered_data" => $data,
        "total_status_1" => $totalStatus1,
        "total_status_2" => $totalStatus2
    ];

    return $response;
}





    public function getKegiatan()
    {
        $berita = Berita::where('kategori_berita' ,'0')->get();
        $responseData = $berita->map(function ($item) {
            $item['gambar_berita'] = asset('foto/berita/' . $item['gambar_berita']); // Ganti path dengan path sesuai dengan penyimpanan foto
            return $item;
        });
        return [
            "status" => 1,
            "data" => $responseData
        ];
        
    }

    public function getBeritaById($id)
    {
        $berita = Berita::where('kategori_berita', '1')->find($id);

        if (!$berita) {
            return [
                "status" => 0,
                "message" => "Berita not found"
            ];
        }
        $berita['gambar_berita'] = asset('foto/berita/' . $berita['gambar_berita']);


        return [
            "status" => 1,
            "data" => $berita
        ];
    }

    public function getKegiatanById($id)
    {
        $kegiatan = Berita::where('kategori_berita', '0')->find($id);

        if (!$kegiatan) {
            return [
                "status" => 0,
                "message" => "Kegiatan not found"
            ];
        }
        $kegiatan['gambar_berita'] = asset('foto/berita/' . $kegiatan['gambar_berita']);


        return [
            "status" => 1,
            "data" => $kegiatan
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
            $tujuan_upload = 'foto/Berita';
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
