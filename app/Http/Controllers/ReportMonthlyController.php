<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LogKm;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class ReportMonthlyController extends Controller
{
    public function index()
    {
        return view('module-report-monthly.index');
    }

    public function listData(Request $request)
    {
        $date_start = $request->date_start;

        $model = LogKm::with(['motor', 'debit', 'credit'])->where('created_at', 'LIKE', '%' . $date_start . '%')->orderBy('created_at', 'ASC')->get();

        $dataArray = $model->map(function ($item) {

            $createdAt = $item->type == 'debit' ? $item->debit->created_at : $item->credit->credit_date;
            $formattedCreatedAt = Carbon::parse($createdAt)->format('Y-m-d');
            $remark = $item->type == 'debit' ? $item->debit->remark : $item->credit->remark;

            return [
                'id' => $item->id,
                'tanggal' => $formattedCreatedAt,
                'motor_name' => $item->motor->name,
                'remark' => $remark,
                'debit' => $item->type == 'debit' ? $item->debit->debit : null,
                'credit' => $item->type == 'credit' ? $item->credit->credit : null,
            ];
        })->toArray();


        return DataTables::of($dataArray)
            ->editColumn('debit', function ($dataArray) {
                return number_format($dataArray['debit'], 0, ',', '.');
            })
            ->editColumn('credit', function ($dataArray) {
                return number_format($dataArray['credit'], 0, ',', '.');
            })
            ->toJson();
    }

    public function printData(Request $request)
    {
        $date_start = $request->dateStart;
        $date_start_formatted = Carbon::parse($date_start)->format('M Y');

        $model = LogKm::with(['motor', 'debit', 'credit'])->where('created_at', 'LIKE', '%' . $date_start . '%')->orderBy('created_at', 'ASC')->get();

        $total_debit = 0;
        $total_credit = 0;
        $dataArray = $model->map(function ($item) use (&$total_debit, &$total_credit) {

            $createdAt = $item->type == 'debit' ? $item->debit->created_at : $item->credit->credit_date;
            $formattedCreatedAt = Carbon::parse($createdAt)->format('Y-m-d');
            $remark = $item->type == 'debit' ? $item->debit->remark : $item->credit->remark;

            if ($item->type == 'debit') {
                $total_debit += $item->debit->debit;
            } else {
                $total_credit += $item->credit->credit;
            }

            return [
                'id' => $item->id,
                'tanggal' => $formattedCreatedAt,
                'motor_name' => $item->motor->name,
                'remark' => $remark,
                'debit' => $item->type == 'debit' ? $item->debit->debit : null,
                'credit' => $item->type == 'credit' ? $item->credit->credit : null,
            ];
        })->toArray();

        $data = [
            'data' => $dataArray,
            'month' => $date_start_formatted,
            'total_debit' => $total_debit,
            'total_credit' => $total_credit,
        ];

        $pdf = Pdf::loadView('module-report-monthly.print', $data);
        $pdf_name = 'Laporan Keuangan Bulan ' . $date_start_formatted . '.pdf';
        return $pdf->stream($pdf_name);
    }
}
