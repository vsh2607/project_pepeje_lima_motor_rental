<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMotor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'nomor_polisi', 'nama_pemilik', 'tahun_pembuatan', 'warna_kb', 'img_url', 'tanggal_pajak', 'tanggal_pembelian', 'harga_sewa_harian', 'harga_sewa_bulanan', 'modal_awal_motor', 'status'];

    public function penyewaans(){
        return $this->hasMany(ModulePenyewaan::class, 'id_master_motor', 'id');
    }

    public function credits(){
        return $this->hasMany(LogCredit::class, 'id_master_motor', 'id');
    }
}
