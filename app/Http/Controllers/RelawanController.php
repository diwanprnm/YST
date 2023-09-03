<?php

namespace App\Http\Controllers;
use App\Models\Relawan;
use App\Models\ProgramRelawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RelawanApproved;



class RelawanController extends Controller
{
    public function getRelawan(Request $request)
    {
    $status = $request->input('status_relawan');

    $query = Relawan::query();

    if ($status !== null) {
        $query->where('status_relawan', $status);
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
    
    public function CreateRelawan(Request $request)
    {
        $request->validate([
            'domisili' => 'required',
            'nama_lengkap' => 'required',

            
        ]);
 
        $user = Auth::user();

        $relawan = $request->all();
        $relawan['id_user'] = $user->id; // Menyimpan id_user yang sedang login
        $relawan['email'] = $user->email; // Menyimpan id_user yang sedang login
        $relawan['no_hp'] = $user->no_hp; // Menyimpan id_user yang sedang login
        $relawan['status_relawan'] = 3;
        $relawan['tgl_daftar'] = now(); // Menggunakan fungsi bawaan PHP untuk mendapatkan waktu saat ini
        


        $new = Donasi::create($donasi);

        // Kirim email
        Mail::to($user->email)->send(new DonasiCreated($new));        return [
            "status" => 1,
            "data" => $relawan,
            "msg" => "relawan created successfully"
        ];
    }

    public function approveRelawan(Request $request, $id)
    {
        $relawan = Relawan::find($id);

        if (!$relawan) {
            return [
                "status" => 0,
                "msg" => "relawan not found"
            ];
        }

        $relawan->status_relawan = 1;
        $relawan->save();

        $programRelawanData = ProgramRelawan::select('nama_program_relawan', 'tgl_pelaksanaan', 'lokasi_program', 'lokasi_awal')
        ->where('id_program_relawan', $relawan->id_program_relawan)
        ->first();

        Mail::to($relawan->email)->send(new RelawanApproved($relawan, $programRelawanData));

        return [
            "status" => 1,
            "msg" => "relawan approved Berhasil"
        ];
    }
    public function rejectRelawan(Request $request, $id)
    {
        $relawan = Relawan::find($id);

        if (!$relawan) {
            return [
                "status" => 0,
                "msg" => "relawan not found"
            ];
        }

        $relawan->status_relawan = 2;
        $relawan->save();

        return [
            "status" => 1,
            "msg" => "relawan reject Berhasil"
        ];
    }


    public function getLaporanRelawan()
    {
        $relawan = DB::table('t_relawan')
        ->join('t_program_relawan', 't_relawan.id_program_relawan', '=', 't_program_relawan.id_program_relawan')
        ->where('t_relawan.status_relawan', '1')
        ->select('t_relawan.id_relawan','t_relawan.nama_lengkap', 't_relawan.tgl_pelaksanaan', 't_relawan.domisili', 't_relawan.no_hp','t_program_relawan.nama_program_relawan as nama_program')
        ->get();      
       
        return [
            "status" => 1,
            "data" => $relawan
        ];
        
    }

    public function LaporanRelawanPDF()
    {
        $relawan = DB::table('t_relawan')
        ->join('t_program_relawan', 't_relawan.id_program_relawan', '=', 't_program_relawan.id_program_relawan')
        ->where('t_relawan.status_relawan', '1')
        ->select('t_relawan.id_relawan','t_relawan.nama_lengkap', 't_relawan.tgl_pelaksanaan', 't_relawan.domisili', 't_relawan.no_hp','t_program_relawan.nama_program_relawan as nama_program')
        ->get();
    
    
        // Menghasilkan tampilan Blade dan mengirimkan data
        $pdf = PDF::loadView('pdf.relawan', ['relawan' => $relawan]);

        $pdf->setPaper('a4', 'portrait'); // 'portrait' untuk tampilan vertikal, 'landscape' untuk tampilan horizontal

    
        // Nama file PDF yang akan dihasilkan
        $filename = 'LaporanRelawan.pdf';
    
        // Mengembalikan respons PDF
        return $pdf->download($filename);
    }
    


}
