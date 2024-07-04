<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LogKm;
use App\Models\LogCredit;
use App\Models\MasterMotor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MasterMotorController extends Controller
{
    public function index()
    {
        return view('master-motor.index');
    }

    public function listData(Request $request)
    {
        $model = MasterMotor::orderBy('id', 'DESC');
        return DataTables::of($model)
            ->editColumn('harga_sewa_harian', function ($model) {
                return  'Rp. ' . number_format($model->harga_sewa_harian, 0, ',', '.');
            })
            ->editColumn('harga_sewa_bulanan', function ($model) {
                return  'Rp. ' . number_format($model->harga_sewa_bulanan, 0, ',', '.');
            })
            ->addColumn('status', function ($model) {
                $status = $model->status == 1 ? "<span class='badge badge-success'>Tersedia</span>" : "<span class='badge badge-danger'>Dipinjam</span>";
                return $status;
            })
            ->addColumn('action', function ($model) {
                $infoButton = "<a href='" . url('master-data/master-motor/' . $model->id . '/info') . "' class='btn  btn-primary d-inline-block'><i class='fas fa-info'></i></a>";
                $editButton = "&nbsp;<a href='" . url('master-data/master-motor/' . $model->id . '/edit') . "' class='btn  btn-warning d-inline-block'><i class='fas fa-edit'></i></a>";
                $deleteButton = "&nbsp;<a href='#' class='btn  btn-danger d-inline-block'><i class='fas fa-trash'></i></a>";
                return $infoButton . $editButton;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    public function listDataMotor(Request $request, $id = null)
    {

        if ($id != null) {
            $data = MasterMotor::where('status',  1)->where('id', $id);
        } else {
            $data = $request->all();
            $search_word = !empty($data) ? $data["name"] : '';
            $data = MasterMotor::where('status',  1)->where('name', 'LIKE', '%' . $search_word . '%');
        }
        $data = $data->get(['id', 'name', 'nomor_polisi']);
        return response()->json($data);
    }


    public function listAllDataMotor(Request $request, $id = null)
    {
        $data = $request->all();
        $search_word = !empty($data) ? $data["name"] : '';
        $data = MasterMotor::where('name', 'LIKE', '%' . $search_word . '%');
        $data = $data->get(['id', 'name', 'nomor_polisi']);
        return response()->json($data);
    }


    public function listDataRented(Request $request)
    {
        $data = $request->all();
        $search_word = array_key_exists("name", $data) ? $data["name"] : '';

        $data = MasterMotor::where('status',  0)->where('nomor_polisi', 'LIKE', '%' . $search_word . '%');

        $data = $data->get(['id', 'name', 'nomor_polisi']);
        return $data;
    }

    public function viewForm($id)
    {
        $data = MasterMotor::where('id', $id)->first();
        return view('master-motor.info', ['data' => $data]);
    }


    public function addForm()
    {
        return view('master-motor.add');
    }

    public function editForm($id)
    {
        $data = MasterMotor::where('id', $id)->first();
        return view('master-motor.edit', ['data' => $data]);
    }

    public function addData(Request $request)
    {


        $request->validate(
            [
                'nomor_polisi' => 'required|unique:master_motors',
                'img_url' => 'image|mimes:jpeg, jpg, png|max:2048'
            ],
            [
                'nomor_polisi.unique' => 'Nomor Polisi sudah ada sebelumnya!'
            ]
        );

        DB::beginTransaction();

        try {


            if ($request->has('img_url')) {
                $image = $request->file('img_url');
                $image_name = time() . $request->name .  '.' . $image->getClientOriginalExtension();
                $destination_path = public_path('motor_images');
                $image->move($destination_path, $image_name);
            }
            $modal_awal_motor = (int) preg_replace('/[^0-9]/', '', $request->input('modal_awal_motor'));

            $dataMotor = MasterMotor::create([
                'name' => $request->input('name'),
                'nomor_polisi' => $request->input('nomor_polisi'),
                'nama_pemilik' => $request->input('nama_pemilik'),
                'tahun_pembuatan' => $request->input('tahun_pembuatan'),
                'warna_kb' => $request->input('warna_kb'),
                'img_url' => $request->has('img_url') ? $image_name : '',
                'tanggal_pajak' => $request->input("tanggal_pajak"),
                'tanggal_pembelian' => $request->input('tanggal_pembelian'),
                'harga_sewa_harian' => (int) preg_replace('/[^0-9]/', '', $request->input('harga_sewa_harian')),
                'harga_sewa_bulanan' => (int) preg_replace('/[^0-9]/', '', $request->input('harga_sewa_bulanan')),
                'modal_awal_motor' => $modal_awal_motor,
                'status' => 1,
            ]);


            $logCredit = LogCredit::create([
                'id_master_motor' => $dataMotor->id,
                'credit' => $modal_awal_motor,
                'total_credit' => LogCredit::totalCredit() + $modal_awal_motor,
                'credit_date' => $request->input('tanggal_pembelian'),
                'remark' => 'BELI AWAL MOTOR'
            ]);


            $tanggal_pembelian = Carbon::parse($request->input('tanggal_pembelian'));

            LogKm::create([
                'id_master_motor' => $dataMotor->id,
                'id_log_target' => $logCredit->id,
                'type' => 'credit',
                'total_km' => (int) preg_replace('/[^0-9]/', '', $request->input('total_km')),
                'created_at' => $tanggal_pembelian->format('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return redirect("master-data/master-motor/")->with("success", "Data berhasil ditambahkan!");
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect("master-data/master-motor/")->with("error", "Data gagal ditambahkan! " . $e->getMessage());
        }
    }

    public function updateData(Request $request, $id)
    {

        $request->validate(
            [
                'nomor_polisi' => "required|unique:master_motors,nomor_polisi,{$id}",
                'img_url' => 'image|mimes:jpeg, jpg, png|max:2048'
            ],
            [
                'nomor_polisi.unique' => 'Nomor Polisi sudah ada sebelumnya!'
            ]
        );

        DB::beginTransaction();
        try {
            $data = MasterMotor::where('id', $id)->first();
            if ($request->has('img_url')) {
                $image = $request->file('img_url');
                $image_name = time() . $request->name .  '.' . $image->getClientOriginalExtension();
                $destination_path = public_path('motor_images');
                $image->move($destination_path, $image_name);

                $image_path = public_path('motor_images/' . $data->img_url . '');
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $total = (int) preg_replace('/[^0-9]/', '', $request->input('modal_awal_motor'));
            $data->update([
                'name' => $request->input('name'),
                'nomor_polisi' => $request->input('nomor_polisi'),
                'nama_pemilik' => $request->input('nama_pemilik'),
                'tahun_pembuatan' => $request->input('tahun_pembuatan'),
                'warna_kb' => $request->input('warna_kb'),
                'img_url' => $request->has('img_url') ? $image_name : $data->img_url,
                'tanggal_pajak' => $request->input("tanggal_pajak"),
                'tanggal_pembelian' => $request->input('tanggal_pembelian'),
                'harga_sewa_harian' => (int) preg_replace('/[^0-9]/', '', $request->input('harga_sewa_harian')),
                'harga_sewa_bulanan' => (int) preg_replace('/[^0-9]/', '', $request->input('harga_sewa_bulanan')),
                'modal_awal_motor' => $total,
            ]);

            $dataLogCredit = LogCredit::where('id_master_motor', $data->id)->where('remark', 'BELI AWAL MOTOR')->first();
            $dataLogCredit->update([
                'credit' => $total,
                'total_credit' => LogCredit::totalCredit() - $dataLogCredit->credit + $total,
            ]);

            DB::commit();
            return redirect("master-data/master-motor/$id/edit")->with("success", "Data berhasil diubah!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("master-data/master-motor/$id/edit")->with("error", "Data gagal ditambahkan! " . $e->getMessage());
        }
    }
}
