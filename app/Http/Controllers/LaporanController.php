<?php

namespace App\Http\Controllers;
use App\Models\Laporan;
use Illuminate\Http\Request;

class laporanController extends Controller
{
    public function getLaporan(Request $request)
    {
        $bulan = $request->input('bulan'); // Bulan yang diberikan dari frontend
        $status = $request->input('status'); // Status yang diberikan dari frontend (0 atau 1)
    
        // Lakukan query untuk menghitung total pemasukan berdasarkan $bulan dan $status
        $totalPemasukan = Laporan::whereMonth('tanggal', $bulan)
            ->where('status', $status)
            ->sum('nominal');
    
        return response()->json([
            'status' => 1,
            'totalPemasukan' => $totalPemasukan,
        ]);
           
    }

    public function CreatePemasukan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'nominal' => 'required',
            'sumber' => 'required',
            'keterangan' => 'required',
            

            
        ]);
        $laporan = $request->all();
        $laporan['status'] = '0';
        Laporan::create($laporan);

        return [
            "status" => 1,
            "data" => $laporan,
            "msg" => "Data Pemasukan created successfully"
        ];
    }

    public function updatePemasukan(Request $request,$id)
    {
        $request->validate([
            'tanggal' => 'required',
            'nominal' => 'required',
            'sumber' => 'required',
            'keterangan' => 'required',
            

            
        ]);

        $laporan = Laporan::find($id);
        $laporan->tanggal = $request->tanggal;
        $laporan->nominal = $request->nominal;
        $laporan->sumber = $request->sumber;
        $laporan->keterangan = $request->keterangan;
        $laporan->save();
       


        return response()->json([
            'message' => 'data laporan berhasil diperbarui',
            'data' => $laporan
        ], 200);
       
    }

    public function CreatePengeluaran(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'nominal' => 'required',
            'sumber' => 'required',
            'keterangan' => 'required',
            

            
        ]);
        $laporan = $request->all();
        $laporan['status'] = '1';
        if ($request->file('bukti_transfer')) {
            $file = $request->file('bukti_transfer');

            $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $tujuan_upload = 'foto/Pengeluaran';
            $file->move($tujuan_upload, $nama_file);
            $data['bukti_transfer'] = $tujuan_upload . '/' . $nama_file;
        }
        Laporan::create($laporan);

        return [
            "status" => 1,
            "data" => $laporan,
            "msg" => "Data pengeluaran created successfully"
        ];
    }

    public function updatePengeluaran(Request $request,$id)
    {
        $request->validate([
            'tanggal' => 'required',
            'nominal' => 'required',
            'sumber' => 'required',
            'keterangan' => 'required',
            

            
        ]);

        $laporan = Laporan::find($id);
        $laporan->tanggal = $request->tanggal;
        $laporan->nominal = $request->nominal;
        $laporan->sumber = $request->sumber;
        $laporan->keterangan = $request->keterangan;
            if ($request->file('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
                $tujuan_upload = 'foto/Pengeluaran';
                $file->move($tujuan_upload, $nama_file);
                $laporan->bukti_transfer = $tujuan_upload . '/' . $nama_file;
            }
        $laporan->save();
       


        return response()->json([
            'message' => 'data pengeluaran berhasil diperbarui',
            'data' => $laporan
        ], 200);
       
    }

    

    public function deleteLaporan($id)
    {
        $laporan = Laporan::find($id);

        if ($laporan) {
            $laporan->delete();

            return response()->json([
                'message' => 'Data laporan berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'message' => 'Data Meninggal tidak ditemukan',
            ], 404);
        }
    }
}


