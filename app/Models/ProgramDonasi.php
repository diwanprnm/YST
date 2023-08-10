<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDonasi extends Model
{
    use HasFactory;
    protected $table = 't_program_donasi';
    protected $guarded = ['id_program_donasi'];
    protected $primaryKey = 'id_program_donasi';
}
