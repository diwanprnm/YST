<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;
    protected $table = 't_wilayah';
    protected $guarded = ['id_wilayah'];
    protected $primarykey = 'id_wilayah';


}
