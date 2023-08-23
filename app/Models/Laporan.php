<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 't_lap_keuangan';
    protected $guarded = ['id_lap_keuangan'];
    protected $primaryKey = 'id_lap_keuangan';



}
