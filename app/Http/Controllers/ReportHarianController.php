<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\LogDebit;
use Illuminate\Http\Request;
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
            ->editColumn('total_hari_sewa', function($model){
                return $model->total_hari_sewa . ' hari';
            })
            ->addColumn('harga_sewa', function($model){
                if($model->penyewaan->jenis_penyewaan == 'harian'){
                    return number_format($model->penyewaan->motor->harga_sewa_harian, 0, ',', '.');
                }
                return number_format($model->penyewaan->motor->harga_sewa_bulanan, 0, ',', '.');

            })
            ->toJson();
    }

    public function printData(Request $request){
        
    }
}
