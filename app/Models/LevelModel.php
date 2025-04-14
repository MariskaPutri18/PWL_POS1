<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    protected $table = 'm_level'; // Nama tabelnya 'level', bukan 'levels'

    protected $primaryKey = 'level_id'; // Primary key nya 'level_id'

    protected $fillable = [
        'level_kode',
        'level_name',
    ];
}
