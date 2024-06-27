<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogDebit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_module_penyewaan', 'debit', 'total_debit', 'remark', 'total_hari_sewa'];


    static public function totalDebit(){
        $total_last_debit = LogDebit::orderBy('total_debit', 'DESC')->select('total_debit')->first();
        $total_last_debit = $total_last_debit->total_debit ?? 0;
        return $total_last_debit;
    }

    static public function addDebit($penyewaan, $total_sewa, $total_hari_sewa)
    {


        if (LogDebit::where('id_module_penyewaan', $penyewaan->id)->first() == null) {
            LogDebit::create([
                'id_module_penyewaan' => $penyewaan->id,
                'debit' => $total_sewa,
                'total_hari_sewa' => $total_hari_sewa,
                'total_debit' => LogDebit::totalDebit() + $total_sewa,
                'remark' => "Sewa, " . $penyewaan->motor->name . ", " . $penyewaan->nama_penyewa
            ]);
        }
    }


    public function penyewaan(){
        return $this->belongsTo(ModulePenyewaan::class, 'id_module_penyewaan', 'id');
    }
}
