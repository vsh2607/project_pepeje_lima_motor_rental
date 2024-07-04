<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LogKm;
use App\Models\LogCredit;
use App\Models\MasterMotor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ModuleAdministrationController extends Controller
{
    public function index()
    {
        return view('module-administration.index');
    }

    public function listData(Request $request)
    {
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        $name = $request->input('name');


        $model = LogCredit::with(['motor'])
            ->whereBetween('credit_date', [$date_start, $date_end])
            ->whereHas('motor', function ($query) use ($name) {
                if ($name != 'all') {
                    return $query->where('id', $name);
                }
            })
            ->orderBy('credit_date', 'ASC');


        return DataTables::of($model)
            ->editColumn('credit', function ($model) {
                return number_format($model->credit, 0, ',', '.');
            })
            ->addColumn('action', function ($model) {
                $infoButton = "<a href='" . url('/module-manajemen/module-administrasi-motor/' . $model->id . '/info') . "' class='btn  btn-primary d-inline-block'><i class='fas fa-info'></i></a>";
                $editButton = "&nbsp;<a href='" . url('/module-manajemen/module-administrasi-motor/' . $model->id . '/edit') . "' class='btn  btn-warning d-inline-block'><i class='fas fa-edit'></i></a>";
                $deleteButton = "&nbsp;<a href='#' class='btn  btn-danger d-inline-block'><i class='fas fa-trash'></i></a>";
                return $infoButton . $editButton;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function addForm()
    {
        return view('module-administration.add');
    }

    public function addData(Request $request)
    {

        $request->validate([
            'id_master_motor' => 'required',
            'credit' => 'required',
            'credit_date' => 'required',
            'remark' => 'required',
            'total_km' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $total = (int) preg_replace('/[^0-9]/', '', $request->input('credit'));
            $logCredit = LogCredit::create([
                'id_master_motor' => $request->input('id_master_motor'),
                'credit' => $total,
                'credit_date' => $request->input('credit_date'),
                'total_credit' => LogCredit::totalCredit() + $total,
                'remark' => $request->input('remark'),
            ]);

            $tanggal_credit = Carbon::parse($request->input('credit_date'));
            LogKm::create([
                'id_master_motor' => $request->input('id_master_motor'),
                'id_log_target' => $logCredit->id,
                'created_at' => $tanggal_credit->format('Y-m-d H:i:s'),
                'type' => 'credit',
                'total_km' => (int) preg_replace('/[^0-9]/', '', $request->input('total_km'))
            ]);

            DB::commit();
            return redirect("/module-manajemen/module-administrasi-motor/")->with("success", "Data berhasil ditambahkan!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("/module-manajemen/module-administrasi-motor/")->with("error", "Data gagal ditambahkan! " . $e->getMessage());
        }
    }


    public function viewForm($id)
    {
        $data = LogCredit::with(['motor', 'logKm'])->where('id', $id)->first();
        return view('module-administration.info', ['data' => $data]);
    }
    public function editForm($id)
    {
        $data = LogCredit::with(['motor', 'logKm'])->where('id', $id)->first();
        return view('module-administration.edit', ['data' => $data]);
    }

    public function updateData(Request $request, $id)
    {

        $request->validate([
            'id_master_motor' => 'required',
            'credit' => 'required',
            'credit_date' => 'required',
            'remark' => 'required',
            'total_km' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $dataLogCredit = LogCredit::with(['motor', 'logKm'])->where('id', $id)->first();

            $dataLogKm = LogKm::where('id', $dataLogCredit->logKm->id)->first();


            $total = (int) preg_replace('/[^0-9]/', '', $request->input('credit'));
            $dataLogCredit->update([
                'id_master_motor' => $request->input('id_master_motor'),
                'credit' => $total,
                'credit_date' => $request->input('credit_date'),
                'total_credit' => LogCredit::totalCredit() - $dataLogCredit->credit + $total,
                'remark' => $request->input('remark'),
            ]);

            if($dataLogCredit->remark == 'BELI AWAL MOTOR'){
                $dataMotor = MasterMotor::where('id', $dataLogCredit->motor->id)->first();
                $dataMotor->update([
                    'modal_awal_motor' => $total
                ]);

            }

            $tanggal_credit = Carbon::parse($request->input('credit_date'));
            $dataLogKm->update([
                'id_master_motor' => $request->input('id_master_motor'),
                'created_at' => $tanggal_credit->format('Y-m-d H:i:s'),
                'total_km' => (int) preg_replace('/[^0-9]/', '', $request->input('total_km'))
            ]);


            DB::commit();
            return redirect("/module-manajemen/module-administrasi-motor/")->with("success", "Data berhasil diubah!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("/module-manajemen/module-administrasi-motor/")->with("error", "Data gagal diubah! " . $e->getMessage());
        }
    }
}
