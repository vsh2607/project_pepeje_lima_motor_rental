<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModulePenyewaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_master_motor', 'nama_penyewa', 'kontak_penyewa', 'jaminan', 'jaminan_img', 'jenis_penyewaan', 'tanggal_penyewaan', 'tanggal_pengembalian', 'status'];

    public function motor(){
        return $this->belongsTo(MasterMotor::class, 'id_master_motor', 'id');
    }
}
