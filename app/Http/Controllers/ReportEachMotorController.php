<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LogKm;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class ReportEachMotorController extends Controller
{
    public function index()
    {
        return view('module-report-each-motor.index');
    }

    public function listData(Request $request)
    {
        $filter_id = $request->name;
        if ($filter_id != null) {
            $model = LogKm::with(['motor', 'debit', 'credit'])->where('id_master_motor', $filter_id)->orderBy('created_at', 'ASC')->get();

            $total_deposit = 0;

            $dataArray = $model->map(function ($item) use (&$total_deposit) {

                $createdAt = $item->type == 'debit' ? $item->debit->created_at : $item->credit->created_at;
                $formattedCreatedAt = Carbon::parse($createdAt)->format('Y-m-d');

                $remark = $item->type == 'debit' ? $item->debit->remark : $item->credit->remark;

                if ($item->type == 'debit') {
                    $total_deposit += $item->debit->debit;
                } else {
                    $total_deposit -= $item->credit->credit;
                }

                return [
                    'id' => $item->id,
                    'tanggal' => $formattedCreatedAt,
                    'total_km' => $item->total_km,
                    'remark' => $remark,
                    'debit' => $item->type == 'debit' ? $item->debit->debit : null,
                    'credit' => $item->type == 'credit' ? $item->credit->credit : null,
                    'total_deposit' => $total_deposit,
                ];
            })->toArray();

            return DataTables::of($dataArray)
                ->editColumn('total_km', function ($dataArray) {
                    return number_format($dataArray['total_km'], 0, ',', '.');
                })->editColumn('debit', function ($dataArray) {
                    return number_format($dataArray['debit'], 0, ',', '.');
                })->editColumn('credit', function ($dataArray) {
                    return number_format($dataArray['credit'], 0, ',', '.');
                })->editColumn('total_deposit', function ($dataArray) {
                    return number_format($dataArray['total_deposit'], 0, ',', '.');
                })
                ->toJson();
        }
        return DataTables::of([])->toJson();
    }

    public function printData(Request $request)
    {
        $filter_id = $request->name;

        if($filter_id == "null"){
            return 'Data Motor Tidak Ada';
        }
        //Jangan buat seperti ini lagi ya len.. -_-
        $model = LogKm::with(['motor', 'debit', 'credit'])->where('id_master_motor', $filter_id)->orderBy('created_at', 'ASC')->get();

        $total_deposit = 0;
        $total_debit = 0;
        $total_credit = 0;
        $dataArray = $model->map(function ($item) use (&$total_deposit, &$total_debit, &$total_credit) {

            $createdAt = $item->type == 'debit' ? $item->debit->created_at : $item->credit->created_at;
            $formattedCreatedAt = Carbon::parse($createdAt)->format('Y-m-d');

            $remark = $item->type == 'debit' ? $item->debit->remark : $item->credit->remark;

            if ($item->type == 'debit') {
                $total_deposit += $item->debit->debit;
                $total_debit += $item->debit->debit;
            } else {
                $total_deposit -= $item->credit->credit;
                $total_credit += $item->credit->credit;
            }

            return [
                'id' => $item->id,
                'tanggal' => $formattedCreatedAt,
                'total_km' => $item->total_km,
                'remark' => $remark,
                'debit' => $item->type == 'debit' ? $item->debit->debit : null,
                'credit' => $item->type == 'credit' ? $item->credit->credit : null,
                'total_deposit' => $total_deposit,

            ];
        })->toArray();

        $data = [
            'motor_name' => $model->first()->motor->name,
            'nomor_polisi' => $model->first()->motor->nomor_polisi,
            'total_debit' => $total_debit,
            'total_credit' => $total_credit,
            'data' => $dataArray,
        ];

        $pdf = Pdf::loadView('module-report-each-motor.print', $data);
        $pdf_name = 'Laporan Keuangan Motor '.$model->first()->motor->name.'.pdf';
        return $pdf->stream($pdf_name);

    }
}
