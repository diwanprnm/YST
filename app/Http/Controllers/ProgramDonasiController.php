<?php

namespace App\Http\Controllers;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;





class ProgramDonasiController extends Controller
{
    public function getProgramDonasi(Request $request)
{
    $status = $request->input('status_program_donasi');

    $query = ProgramDonasi::query();

    if ($status !== null) {
        $query->where('status_program_donasi', $status);
    }

    $data = $query->get();
    $responseData = $data->map(function ($item) {
        $item['foto_p_donasi'] = asset('foto/Programdonasi/' . $item['foto_p_donasi']);
        return $item;
    });

    // Menghitung jumlah status_program_donasi 0
    $totalStatus0 = $data->where('status_program_donasi', 0)->count();

    // Menghitung jumlah status_program_donasi 1
    $totalStatus1 = $data->where('status_program_donasi', 1)->count();

    if ($status !== null) {
        return [
            "status" => 1,
            "filtered_data" => $responseData,
            "total_status_0" => $totalStatus0,
            "total_status_1" => $totalStatus1,
        ];
    } else {
        return [
            "status" => 1,
            "data" => $responseData,
            "total_status_0" => $totalStatus0,
            "total_status_1" => $totalStatus1,
        ];
    }
}


    public function getLaporanProgramDonasi()
    {
        $donasi = ProgramDonasi::select('t_program_donasi.id_program_donasi', 't_program_donasi.nama_program_donasi', 't_program_donasi.penanggung_jawab', 't_program_donasi.tgl_penyaluran','t_program_donasi.penerima_donasi', DB::raw('SUM(t_donasi.nominal_donasi) as total_nominal_donasi'))
        ->leftJoin('t_donasi', 't_program_donasi.id_program_donasi', '=', 't_donasi.id_program_donasi')
        ->where('t_program_donasi.status_program_donasi', '3')
        ->groupBy('t_program_donasi.id_program_donasi', 't_program_donasi.nama_program_donasi', 't_program_donasi.penanggung_jawab', 't_program_donasi.tgl_penyaluran','t_program_donasi.penerima_donasi')
        ->get();      
       
        return [
            "status" => 1,
            "data" => $donasi
        ];
        
    }


public function getProgramDonasiPaginate(Request $request)
{
    $status = $request->input('status_program_donasi');

    $query = ProgramDonasi::query();

    if ($status !== null) {
        $query->where('status_program_donasi', $status);
    }

    $data = $query->orderBy('created_at', 'desc')->paginate(3); // Urutkan dan paginasi data dengan 3 data per halaman
    $responseData = $data->map(function ($item) {
        $item['foto_p_donasi'] = asset('foto/Programdonasi/' . $item['foto_p_donasi']);
        return $item;
    });

    if ($status !== null) {
        return [
            "status" => 1,
            "filtered_data" => $responseData
        ];
    } else {
        return [
            "status" => 1,
            "data" => $responseData
        ];
    }
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
    $program_donasi['foto_p_donasi'] = asset('foto/Programdonasi/' . $program_donasi['foto_p_donasi']);

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
            'deskripsi_lengkap_donasi' => 'required',
            'target_dana' => 'required',
            'tgl_selesai' => 'required',
            'tgl_pdonasi' => 'required',
            'penanggung_jawab' => 'required',
            'jangka_waktu' => 'required',
            'kategori_donasi' => 'required',
            'penerima_donasi' => 'required',
            'foto_p_donasi' => 'required',
            'tgl_penyaluran' => 'required',
            
            

            
        ]);
        $data = $request->all();
        $data['status_program_donasi'] = '0';

        if ($request->file('foto_p_donasi')) {
            $file = $request->file('foto_p_donasi');

            $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $tujuan_upload = 'foto/Programdonasi';
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
                'tgl_pdonasi' => 'required',
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
            $data->tgl_pdonasi = $request->tgl_pdonasi;
            $data->penanggung_jawab = $request->penanggung_jawab;
            $data->jangka_waktu = $request->jangka_waktu;
            $data->penerima_donasi = $request->penerima_donasi;
            $data->kategori_donasi = $request->kategori_donasi;
            $data->status_program_donasi = $request->status_program_donasi;
           
            $data->save();
           
            return response()->json([
                'message' => 'data Beasiswa berhasil diperbarui',
                'data' => $data
            ], 200);
           
        }

        public function approveProgramDonasi(Request $request, $id)
        {
            $program_donasi = ProgramDonasi::find($id);
    
            if (!$program_donasi) {
                return [
                    "status" => 0,
                    "msg" => "program donasi not found"
                ];
            }
    
            $program_donasi->status_program_donasi = '1';
            $program_donasi->save();
    
            return [
                "status" => 1,
                "msg" => "program donasi approved Berhasil"
            ];
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


        public function LaporanProgramDonasiPDF()
{
    $donasi = ProgramDonasi::select('t_program_donasi.id_program_donasi', 't_program_donasi.nama_program_donasi', 't_program_donasi.penanggung_jawab', 't_program_donasi.tgl_penyaluran','t_program_donasi.penerima_donasi', DB::raw('SUM(t_donasi.nominal_donasi) as total_nominal_donasi'))
        ->leftJoin('t_donasi', 't_program_donasi.id_program_donasi', '=', 't_donasi.id_program_donasi')
        ->where('t_program_donasi.status_program_donasi', '3')
        ->groupBy('t_program_donasi.id_program_donasi', 't_program_donasi.nama_program_donasi', 't_program_donasi.penanggung_jawab', 't_program_donasi.tgl_penyaluran','t_program_donasi.penerima_donasi')
        ->get();

    $pdf = PDF::loadView('pdf.programdonasi', ['donasi' => $donasi]);

    $pdf->setPaper('a4', 'portrait');

    $filename = 'programDonasi.pdf';

    $content = $pdf->output();

    return response($content, 200)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'inline; filename="' . $filename . '"');


}
}





