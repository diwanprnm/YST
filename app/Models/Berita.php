<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $table = 't_berita';
    protected $guarded = ['id_berita'];
    protected $primaryKey = 'id_berita';



}
