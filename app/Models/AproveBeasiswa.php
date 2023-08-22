<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AproveBeasiswa extends Model
{
    use HasFactory;
    protected $table = 't_approval_beasiswa';
    protected $guarded = ['id_approval'];
    protected $primaryKey = 'id_approval';

    public $timestamps = false; // Nonaktifkan timestamps

}
