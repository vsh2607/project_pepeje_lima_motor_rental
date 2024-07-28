<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LogKm;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportTotalMonthController extends Controller
{
    public function index()
    {
        return view('module-report-total-month.index');
    }

    public function listData(Request $request)
    {
        $year = $request->filter_by_year;

        $model = LogKm::with(['credit', 'debit'])
            ->select(
                DB::raw('DATE_FORMAT(log_kms.created_at, "%Y-%m") as formatted_date'),
                DB::raw('SUM(log_credits.credit) as total_credit'),
                DB::raw('SUM(log_debits.debit) as total_debit')
            )
            ->leftJoin('log_credits', 'log_kms.id_log_target', '=', 'log_credits.id')
            ->leftJoin('log_debits', 'log_kms.id_log_target', '=', 'log_debits.id')
            ->whereYear('log_kms.created_at', $year)
            ->groupBy(DB::raw('DATE_FORMAT(log_kms.created_at, "%Y-%m")'));




        return DataTables::of($model)
            ->editColumn('formatted_date', function ($model) {
                $date = Carbon::createFromFormat('Y-m', $model->formatted_date);
                return $date->format('F Y');
            })
            ->editColumn('total_credit', function($model){
                return number_format($model->total_credit, 0, ',','.');
            })
            ->editColumn('total_debit', function($model){
                return number_format($model->total_debit, 0, ',','.');
            })
            ->addColumn('total_deposit', function($model){
                $total_deposit = $model->total_debit - $model->total_credit;
                return number_format($total_deposit, 0, ',','.');

            })
            ->toJson();
    }



    public function printData(Request $request){


        $year = $request->year;

        $data = LogKm::with(['credit', 'debit'])
            ->select(
                DB::raw('DATE_FORMAT(log_kms.created_at, "%Y-%m") as formatted_date'),
                DB::raw('SUM(log_credits.credit) as total_credit'),
                DB::raw('SUM(log_debits.debit) as total_debit'),
                DB::raw('SUM(log_debits.debit) - SUM(log_credits.credit) as total_deposit')
            )
            ->leftJoin('log_credits', 'log_kms.id_log_target', '=', 'log_credits.id')
            ->leftJoin('log_debits', 'log_kms.id_log_target', '=', 'log_debits.id')
            ->whereYear('log_kms.created_at', $year)
            ->groupBy(DB::raw('DATE_FORMAT(log_kms.created_at, "%Y-%m")'))->get();

        $total_debit = 0;
        $total_credit = 0;
        $total_deposit = 0;

        foreach($data as $item){
            $total_debit += $item->total_debit;
            $total_credit += $item->total_credit;
            $total_deposit += $item->total_deposit;
        }

            $data = [
                'data' => $data,
                'year' => $year,
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'total_deposit' => $total_deposit
            ];

            $pdf = Pdf::loadView('module-report-total-month.print', $data);
            $pdf_name = 'Laporan Total Tiap Bulan Tahun '.$year.'.pdf';
            return $pdf->stream($pdf_name);

    }
}
