<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meninggal extends Model
{
    use HasFactory;
    protected $table = 't_meninggal';
    protected $guarded = ['id_meninggal'];
    protected $primaryKey = 'id_meninggal';



}
