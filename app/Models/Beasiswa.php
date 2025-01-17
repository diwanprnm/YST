<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;
    protected $table = 't_beasiswa';
    protected $guarded = ['id_beasiswa'];
    protected $primaryKey = 'id_beasiswa';

    public $timestamps = false; // Nonaktifkan timestamps

}
