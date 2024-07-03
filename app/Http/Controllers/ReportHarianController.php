<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\LogDebit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;


class ReportHarianController extends Controller
{
    public function index()
    {
        return view('module-report-harian.index');
    }

    public function listData(Request $request)
    {
        $filter_name = $request->name;
        $filter_date_start = $request->date_start;
        $filter_date_end = $request->date_end;

        $model = LogDebit::with(['penyewaan', 'penyewaan.motor'])
            ->whereHas('penyewaan', function ($query) use ($filter_date_start, $filter_date_end) {
                $query->whereBetween('tanggal_pengembalian', [$filter_date_start, $filter_date_end]);
            })
            ->whereHas('penyewaan.motor', function ($query) use ($filter_name) {
                if ($filter_name != 'all') {
                    $query->where('id', $filter_name);
                }
            })->orderBy('total_hari_sewa', 'DESC');

        return Datatables::of($model)
            ->editColumn('debit', function ($model) {
                return number_format($model->debit, 0, ',', '.');
            })
            ->editColumn('total_hari_sewa', function ($model) {
                return $model->total_hari_sewa . ' hari';
            })
            ->addColumn('harga_sewa', function ($model) {
                if ($model->penyewaan->jenis_penyewaan == 'harian') {
                    return number_format($model->penyewaan->motor->harga_sewa_harian, 0, ',', '.') . ' ('.$model->penyewaan->jenis_penyewaan.')';
                }
                return number_format($model->penyewaan->motor->harga_sewa_bulanan, 0, ',', '.') . ' ('.$model->penyewaan->jenis_penyewaan.')';
            })
            ->toJson();
    }

    public function printData(Request $request)
    {

        $filter_name = $request->name;
        $filter_date_start = $request->dateStart;
        $filter_date_end = $request->dateEnd;



        $model = LogDebit::with(['penyewaan', 'penyewaan.motor'])
            ->whereHas('penyewaan', function ($query) use ($filter_date_start, $filter_date_end) {
                $query->whereBetween('tanggal_pengembalian', [$filter_date_start, $filter_date_end]);
            })
            ->whereHas('penyewaan.motor', function ($query) use ($filter_name) {
                if ($filter_name != 'all') {
                    $query->where('id', $filter_name);
                }
            })->orderBy('total_hari_sewa', 'DESC')->get();

        $model_sum = $model->sum('debit');

        $data = [
            'date_start' => $filter_date_start,
            'date_end' => $filter_date_end,
            'motor_name' => $filter_name == "all" ?  'Semua Motor' : $model->first()->penyewaan->motor->name,
            'data' => $model,
            'total_harga_sewa' => $model_sum
        ];

        $pdf = Pdf::loadView('module-report-harian.print', $data);
        $pdf_name = 'Laporan Sewa Harian.pdf';
        return $pdf->stream($pdf_name);
    }
}
