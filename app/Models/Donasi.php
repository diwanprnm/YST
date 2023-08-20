<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;
    protected $table = 't_donasi';
    protected $guarded = ['id_donasi'];
    protected $primaryKey = 'id_donasi';



}
