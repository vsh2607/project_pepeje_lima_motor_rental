<?php

namespace App\Http\Controllers;

use App\Models\LogDebit;
use App\Models\MasterMotor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $total_motor = MasterMotor::count();
        $total_motor_available = MasterMotor::where('status', 1)->count();

        $total_debit = LogDebit::orderBy('total_debit', 'DESC')->select('total_debit')->first();
        $total_debit = $total_debit->total_debit ?? 0;
        $total_debit = 'Rp '. number_format($total_debit, 0, ',', '.');

        return view('dashboard.index', ['total_motor' => $total_motor, 'total_motor_available' => $total_motor_available, 'total_debit' => $total_debit]);
    }
}
