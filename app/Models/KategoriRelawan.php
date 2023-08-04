<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriRelawan extends Model
{
    use HasFactory;
    protected $table = 't_kat_relawan';
    protected $guarded = ['id_kat_relawan'];
    protected $primaryKey = 'id_kat_relawan';



}
