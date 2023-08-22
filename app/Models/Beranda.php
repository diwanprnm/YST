<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    use HasFactory;
    protected $table = 't_konten_beranda';
    protected $guarded = ['id_banner'];
    protected $primaryKey = 'id_banner';
}
