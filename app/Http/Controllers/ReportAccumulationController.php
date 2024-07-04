<?php

namespace App\Http\Controllers;

use App\Models\MasterMotor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ReportAccumulationController extends Controller
{
    public function index()
    {
        return view('module-report-accumulation.index');
    }

    public function listData()
    {
        $model = MasterMotor::withSum('credits', 'credit')->withSum('debits', 'debit')->get();
        return DataTables::of($model)
            ->addColumn('total_saldo', function ($model) {
                $total_saldo = $model->debits_sum_debit - $model->credits_sum_credit;
                return number_format($total_saldo, 0, ',', '.');
            })
            ->editColumn('credits_sum_credit', function ($model) {
                return number_format($model->credits_sum_credit, 0, ',', '.');
            })
            ->editColumn('debits_sum_debit', function ($model) {
                return number_format($model->debits_sum_debit, 0, ',', '.');
            })
            ->toJson();
    }

    public function printData()
    {

        $model = MasterMotor::withSum('credits', 'credit')->withSum('debits', 'debit')->get();


        $total_debit = 0;
        $total_credit = 0;

        $dataArray = $model->map(function ($item) use(&$total_debit, &$total_credit) {


                $total_debit += $item->debits_sum_debit;
                $total_credit +=  $item->credits_sum_credit;

            return [
                'motor_name' => $item->name,
                'credit' => $item->credits_sum_credit,
                'debit' => $item->debits_sum_debit,
                'total_saldo' => $item->debits_sum_debit - $item->credits_sum_credit
            ];
        })->toArray();

        $data = [
            'data' => $dataArray,
            'total_debit' => $total_debit,
            'total_credit' => $total_credit,
        ];


        $pdf = Pdf::loadView('module-report-accumulation.print', $data);
        $pdf_name = 'Laporan Akumlasi.pdf';
        return $pdf->stream($pdf_name);
    }
}
