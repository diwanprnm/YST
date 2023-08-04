<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriDonasi extends Model
{
    use HasFactory;
    protected $table = 't_kat_donasi';
    protected $guarded = ['id_kat_donasi'];
    protected $primaryKey = 'id_kat_donasi';



}
