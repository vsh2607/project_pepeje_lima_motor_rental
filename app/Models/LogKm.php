<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogKm extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['id_master_motor', 'id_log_target', 'type', 'total_km'];

}
