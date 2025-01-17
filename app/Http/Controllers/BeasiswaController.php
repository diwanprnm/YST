<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\AproveBeasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class BeasiswaController extends Controller
{
    public function getBeasiswa(Request $request){
        $id = $request->input('id_beasiswa');
        
        $query = Beasiswa::query();
        
        $query->join('t_meninggal', 't_beasiswa.user_nik', '=', 't_meninggal.nik');
        $query->leftJoin('t_approval_beasiswa', 't_beasiswa.id_beasiswa', '=', 't_approval_beasiswa.beasiswa_id');
        $query->leftJoin('users', 't_approval_beasiswa.user_id', '=', 'users.id');
        
        $query->addSelect([
            't_beasiswa.*',
            't_meninggal.nama as nama_pengajuan_beasiswa',
            DB::raw('(SELECT COUNT(*) FROM t_approval_beasiswa WHERE t_approval_beasiswa.beasiswa_id = t_beasiswa.id_beasiswa) as jumlah_peng_approve')
        ]); 
        
        if ($id !== null) {
            $query->where('id_beasiswa', $id);
        }
        
        $data = $query->get();
        
        $uniqueData = []; // Array untuk menyimpan data unik berdasarkan "id_beasiswa"
        
        foreach ($data as $beasiswa) {
            // Menyimpan data ke dalam array dengan "id_beasiswa" sebagai kunci
            $uniqueData[$beasiswa->id_beasiswa] = $beasiswa;
        }
        
        // Mengonversi kembali array asosiatif ke dalam format JSON
        $uniqueData = array_values($uniqueData);
        
        foreach ($uniqueData as $beasiswa) {
            $beasiswa->approval = AproveBeasiswa::where('beasiswa_id', $beasiswa->id_beasiswa)->get(['user_id','id_approval','keterangan']);
            
            foreach ($beasiswa->approval as $approval) {
                $user = User::find($approval->user_id);
                if ($user) {
                    $approval->nama_approve = $user->name;
                }
            }
        }
        
        
        $response = [
            "status" => 1,
            "data" => $uniqueData, // Menggunakan data yang sudah tidak memiliki duplikat
        ];
        
        return $response;
    }
    
    

    public function CreateBeasiswa(Request $request)
    {
        
        $request->validate([
            'user_nik' => 'required',
            'tgl' => 'required',
            'nama_anak1' => 'required',
            'jenjang_pendidikan1' => 'required',
            'nama_bank1' => 'required',
            'keterangan' => 'required'

            
        ]);
        $data = $request->all();
        $data['status'] = '0';
        Beasiswa::create($data);
        return [
            "status" => 1,
            "data" => $data,
            "msg" => "Data Beasiswa created successfully"
        ];
    }

    public function updateBeasiswa(Request $request,$id_beasiswa)
    {
        $request->validate([
            'user_nik' => 'required',
            'tgl' => 'required',
            'nama_anak1' => 'required',
            'jenjang_pendidikan1' => 'required',
            'nama_bank1' => 'required',
            'keterangan' => 'required'
            
        ]);

        $data = Beasiswa::find($id_beasiswa);
        $data->user_nik = $request->user_nik;
        $data->tgl = $request->tgl;
        $data->nama_anak1 = $request->nama_anak1;
        $data->nama_anak2 = $request->nama_anak2;
        $data->nama_anak3 = $request->nama_anak3;
        $data->jenjang_pendidikan1 = $request->jenjang_pendidikan1;
        $data->jenjang_pendidikan2 = $request->jenjang_pendidikan2;
        $data->jenjang_pendidikan3 = $request->jenjang_pendidikan3;
        $data->nominal_1 = $request->nominal_1;
        $data->nominal_2 = $request->nominal_2;
        $data->nominal_3 = $request->nominal_3;
        $data->nama_bank1 = $request->nama_bank1;
        $data->nama_bank2 = $request->nama_bank2;
        $data->nama_bank3 = $request->nama_bank3;
        $data->nomor_rekening1 = $request->nomor_rekening1;
        $data->nomor_rekening2 = $request->nomor_rekening2;
        $data->nomor_rekening3 = $request->nomor_rekening3;
        $data->total_nominal = $request->total_nominal;
        $data->keterangan = $request->keterangan;
        $data->save();
       
        return response()->json([
            'message' => 'data Beasiswa berhasil diperbarui',
            'data' => $data
        ], 200);
       
    }

    public function deleteBeasiswa($id_beasiswa)
    {
        $beasiswa = Beasiswa::find($id_beasiswa);

        if ($beasiswa) {
            $beasiswa->delete();

            return response()->json([
                'message' => 'beasiswa berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'message' => 'beasiswa tidak ditemukan',
            ], 404);
        }
    }

    public function approveBeasiswa(Request $request, $id)
{
    // Find the beasiswa by its ID
    $beasiswa = Beasiswa::findOrFail($id);

    $user = Auth::user(); // The logged-in user

    // Check if the user has already given approval
    $existingApproval = AproveBeasiswa::where('beasiswa_id', $id)
        ->where('user_id', $user->id)
        ->first();

    // If the user has not already given approval
    if (!$existingApproval) {
        // Create a new approval record
        $approval = new AproveBeasiswa([
            'beasiswa_id' => $id,
            'user_id' => $user->id,
            'is_approve' => true, // Set approval to true
            'approved_at' => now(), // Set the approval timestamp
            'keterangan' => $request->input('keterangan'), // Capture notes from request
        ]);
        $approval->save();
        
    }

    // Count the number of approvals received
    $approvalCount = AproveBeasiswa::where('beasiswa_id', $id)->count();

    // If there are at least two approvals, update the beasiswa status
    if ($approvalCount >= 2) {
        $beasiswa->is_approve = true; // Set beasiswa status to approved
        $beasiswa->status = '1'; // Set beasiswa status to approved
        $beasiswa->approved_at = now(); // Save approval time
        $beasiswa->approved_by = $user->username; // Save user who gave approval
        $beasiswa->save();
    }

    // Return a response indicating the approval status
    return [
        "status" => 1,
        "msg" => "Beasiswa approval process completed"
    ];
}

    public function rejectBeasiswa(Request $request, $id)
    {
        // Find the beasiswa by its ID
        $beasiswa = Beasiswa::findOrFail($id);

        $user = Auth::user(); // The logged-in user

        // Check if the user has already given approval
        $existingApproval = AproveBeasiswa::where('beasiswa_id', $id)
            ->where('user_id', $user->id)
            ->first();

        // If the user has not already given approval
        if (!$existingApproval) {
            // Create a new approval record
            $approval = new AproveBeasiswa([
                'beasiswa_id' => $id,
                'user_id' => $user->id,
                'is_approve' => false, // Set approval to true
                'approved_at' => now(), // Set the approval timestamp
                'keterangan' => $request->input('keterangan'), // Capture notes from request
            ]);
            $approval->save();
            
        }

        // Count the number of approvals received
        $approvalCount = AproveBeasiswa::where('beasiswa_id', $id)->count();

        // If there are at least two approvals, update the beasiswa status
        if ($approvalCount >= 2) {
            $beasiswa->is_approve = false; // Set beasiswa status to approved
            $beasiswa->status = '2'; // Set beasiswa status to approved
            $beasiswa->approved_at = now(); // Save approval time
            $beasiswa->approved_by = $user->username; // Save user who gave approval
            $beasiswa->save();
        }

        // Return a response indicating the approval status
        return [
            "status" => 1,
            "msg" => "Beasiswa reject process completed"
        ];
    }

    


    

    



}
