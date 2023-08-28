<?php

namespace App\Http\Controllers;

use App\Models\Beranda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

 
        // Add this line


        class BerandaController extends Controller
        {
        

            public function createOrUpdateBeranda(Request $request)
                {
                    $existingBeranda = Beranda::first(); // Mencari data konten beranda yang sudah ada

                    if ($existingBeranda) {
                        // Jika data konten beranda sudah ada, lakukan pembaruan
                    
                    } else {
                        // Jika data konten beranda belum ada, lakukan pembuatan
                        return $this->createBeranda($request);
                    }
                }

                protected function createBeranda(Request $request)
                {
                    $request->validate([
                        'Judul' => 'required',
                        'Deskripsi' => 'required',
                        'buttonText' => 'required',
                        'Gambar' => 'required',
                    ]);

                    $data = $request->all();
                    if ($request->file('Gambar')) {
                        $file = $request->file('Gambar');
                        $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
                        $tujuan_upload = 'foto/Beranda';
                        $file->move($tujuan_upload, $nama_file);
                        $data['Gambar'] = $tujuan_upload . '/' . $nama_file;
                    }
                    
                    Beranda::create($data);
                    
                    return [
                        "status" => 1,
                        "data" => $data,
                        "msg" => "Konten Beranda created successfully"
                    ];
                }

                protected function updateBeranda(Request $request, Beranda $beranda)
                {
                    $request->validate([
                        'Judul' => 'required',
                        'Deskripsi' => 'required',
                        'buttonText' => 'required',
                    ]);

                    $data = $request->all();
                    if ($request->file('Gambar')) {
                        $file = $request->file('Gambar');
                        $nama_file = 'img_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
                        $tujuan_upload = 'foto/Beranda';
                        $file->move($tujuan_upload, $nama_file);
                        $data['Gambar'] = $tujuan_upload . '/' . $nama_file;
                    }
                    
                    $beranda->update($data);
                    
                    return [
                        "status" => 1,
                        "data" => $data,
                        "msg" => "Konten Beranda updated successfully"
                    ];
                }


            
            


            

            



        }
