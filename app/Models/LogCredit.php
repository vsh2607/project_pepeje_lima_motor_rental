<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogCredit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_master_motor', 'credit', 'total_credit', 'remark', 'credit_date'];

    static public function totalCredit(){
        $total_last_credit = LogCredit::orderBy('total_credit', 'DESC')->select('total_credit')->first();
        $total_last_credit = $total_last_credit->total_credit ?? 0;
        return $total_last_credit;
    }

    public function motor(){
        return $this->belongsTo(MasterMotor::class, 'id_master_motor', 'id');
    }

    public function logKm(){
        return $this->belongsTo(LogKm::class, 'id', 'id_log_target');
    }
}
