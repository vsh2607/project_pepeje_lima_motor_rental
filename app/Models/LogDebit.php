<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogDebit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_module_penyewaan', 'debit', 'total_debit', 'remark'];

    static public function addDebit($penyewaan, $total_sewa)
    {
        $total_last_debit = LogDebit::orderBy('id', 'DESC')->select('total_debit')->first();
        $total_last_debit = $total_last_debit->total_debit ?? 0;

        if (LogDebit::where('id_module_penyewaan', $penyewaan->id)->first() == null) {
            LogDebit::create([
                'id_module_penyewaan' => $penyewaan->id,
                'debit' => $total_sewa,
                'total_debit' => $total_last_debit + $total_sewa,
                'remark' => "Sewa, " . $penyewaan->motor->name . ", " . $penyewaan->nama_penyewa
            ]);
        }
    }
}
