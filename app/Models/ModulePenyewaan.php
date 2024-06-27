<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulePenyewaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_master_motor', 'nama_penyewa', 'kontak_penyewa', 'jaminan', 'jaminan_img', 'jenis_penyewaan', 'tanggal_penyewaan', 'tanggal_pengembalian', 'status'];

    public function motor()
    {
        return $this->belongsTo(MasterMotor::class, 'id_master_motor', 'id');
    }

    public static function getTotalHariHargaSewa($data)
    {
        $tanggal_penyewaan = new DateTime($data->tanggal_penyewaan);
        if ($data->tanggal_pengembalian != null) {
            $tanggal_akhir = new DateTime($data->tanggal_pengembalian);
        } else {
            $tanggal_akhir = new DateTime();
        }
        $interval = $tanggal_akhir->diff($tanggal_penyewaan)->days;
        $total_sewa = 0;

        if ($data->jenis_penyewaan == 'harian') {
            $total_sewa = $interval <= 0 ? $data->motor->harga_sewa_harian : $data->motor->harga_sewa_harian * $interval;
        } else {
            $total_month = (int)ceil($interval / 30);
            $total_sewa = $total_month <= 0 ? $data->motor->harga_sewa_bulanan : $data->motor->harga_sewa_bulanan * $total_month;

        }
        return [
            'interval_sewa' => $interval,
            'harga_sewa' => $total_sewa
        ];
    }
}
