<?php

namespace App\Http\Controllers;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonasiCreated;
use App\Mail\DonasiApproved;


use Illuminate\Support\Facades\DB;





class DonasiController extends Controller
{
    public function getDonasi(Request $request)
    {
    $status = $request->input('status_donasi');

    $query = Donasi::query();

    if ($status !== null) {
        $query->where('status_donasi', $status);
    }

    $data = $query->get();

    if ($status !== null) {
        return [
            "status" => 1,
            "filtered_data" => $data
        ];
    } else {
        return [
            "status" => 1,
            "data" => $data
        ];
    }
}
    
public function CreateDonasi(Request $request)
{
    $request->validate([
        'nama_donatur' => 'required',
        'nominal_donasi' => 'required',
    ]);

    $user = Auth::user();

    $donasi = $request->all();
    $donasi['id_user'] = $user->id;
    $donasi['email'] = $user->email;
    $donasi['status_donasi'] = 2;

    $nominalDonasi = $request->input('nominal_donasi');
    $donasi['belum_dibayar'] = $nominalDonasi + rand(100, 999);

    $donasi['tgl_donasi'] = now();

    $newDonasi = Donasi::create($donasi);

    // Kirim email
    Mail::to($user->email)->send(new DonasiCreated($newDonasi));

    return [
        "status" => 1,
        "data" => $newDonasi,
        "msg" => "Donasi created successfully"
    ];
}

    public function approveDonasi(Request $request, $id)
    {
        $donasi = Donasi::find($id);

        if (!$donasi) {
            return [
                "status" => 0,
                "msg" => "Donasi not found"
            ];
        }

        $donasi->status_donasi = 1;
        $donasi->save();
        Mail::to($donasi->email)->send(new DonasiApproved($donasi));


        return [
            "status" => 1,
            "msg" => "Donasi verifikasi Berhasil"
        ];
    }

    public function getLaporanDonasi()
    {
        $donasi = DB::table('t_donasi')
        ->join('t_program_donasi', 't_donasi.id_program_donasi', '=', 't_program_donasi.id_program_donasi')
        ->where('t_donasi.status_donasi', '1')
        ->select('t_donasi.id_donasi','t_donasi.nama_donatur', 't_donasi.nominal_donasi', 't_donasi.tgl_donasi', 't_program_donasi.nama_program_donasi as nama_program')
        ->get();
          
       
        return [
            "status" => 1,
            "data" => $donasi
        ];
        
    }

    public function LaporanDonasiPDF()
    {
        $donasi = DB::table('t_donasi')
        ->join('t_program_donasi', 't_donasi.id_program_donasi', '=', 't_program_donasi.id_program_donasi')
        ->where('t_donasi.status_donasi', '1')
        ->select('t_donasi.id_donasi','t_donasi.nama_donatur', 't_donasi.nominal_donasi', 't_donasi.tgl_donasi', 't_program_donasi.nama_program_donasi as nama_program')
        ->get();
    
    
        // Menghasilkan tampilan Blade dan mengirimkan data
        $pdf = PDF::loadView('pdf.program_donasi_list', ['donasi' => $donasi]);

        $pdf->setPaper('a4', 'portrait'); // 'portrait' untuk tampilan vertikal, 'landscape' untuk tampilan horizontal

    
        // Nama file PDF yang akan dihasilkan
        $filename = 'program_donasi_list.pdf';
    
        // Mengembalikan respons PDF
        return $pdf->download($filename);
    }
    
    

}


