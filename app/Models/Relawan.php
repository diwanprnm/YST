<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;
    protected $table = 't_relawan';
    protected $guarded = ['id_relawan'];
    protected $primaryKey = 'id_relawan';



}
