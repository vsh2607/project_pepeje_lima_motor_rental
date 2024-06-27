<?php

namespace App\Http\Controllers;

use App\Models\LogCredit;
use App\Models\LogDebit;
use App\Models\MasterMotor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $total_motor = MasterMotor::count();
        $total_motor_available = MasterMotor::where('status', 1)->count();

        $total_debit = LogDebit::totalDebit();
        $total_credit = LogCredit::totalCredit();
        $total_deposit = $total_debit - $total_credit;

        $total_debit = 'Rp '. number_format($total_debit, 0, ',', '.');
        $total_credit = 'Rp '. number_format($total_credit, 0, ',', '.');
        $total_deposit = 'Rp '. number_format($total_deposit, 0, ',', '.');




        return view('dashboard.index', ['total_motor' => $total_motor, 'total_motor_available' => $total_motor_available, 'total_debit' => $total_debit, 'total_credit'=> $total_credit, 'total_deposit' => $total_deposit]);
    }
}
