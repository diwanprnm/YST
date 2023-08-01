<?php

namespace App\Http\Controllers;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getWilayahs()
    {
        $wilayahs = Wilayah::all();
        return response()->json($wilayahs);
    }
}
