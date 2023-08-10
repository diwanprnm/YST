<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramRelawan extends Model
{
    use HasFactory;
    protected $table = 't_program_relawan';
    protected $guarded = ['id_program_relawan'];
    protected $primaryKey = 'id_program_relawan';
}
