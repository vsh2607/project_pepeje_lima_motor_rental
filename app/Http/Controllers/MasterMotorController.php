<?php

namespace App\Http\Controllers;


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

    public function listData()
    {
        $model = MasterMotor::query();
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

    public function viewForm($id){
        $data = MasterMotor::where('id', $id)->first();
        return view('master-motor.info', ['data' => $data]);
    }

    public function addForm()
    {
        return view('master-motor.add');
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

            if ($request->hasFile('img_url')) {
                $image = $request->file('img_url');
                $image_name = time() . $request->name .  '.' . $image->getClientOriginalExtension();
                $destination_path = public_path('motor_images');
                $image->move($destination_path, $image_name);
            }

            MasterMotor::create([
                'name' => $request->input('name'),
                'nomor_polisi' => $request->input('nomor_polisi'),
                'nama_pemilik' => $request->input('nama_pemilik'),
                'tahun_pembuatan' => $request->input('tahun_pembuatan'),
                'warna_kb' => $request->input('warna_kb'),
                'img_url' => $image_name,
                'tanggal_pajak' => $request->input("tanggal_pajak"),
                'tanggal_pembelian' => $request->input('tanggal_pembelian'),
                'harga_sewa_harian' => (int) preg_replace('/[^0-9]/', '', $request->input('harga_sewa_harian')),
                'harga_sewa_bulanan' => (int) preg_replace('/[^0-9]/', '', $request->input('harga_sewa_bulanan')),
                'status' => 1,
            ]);

            DB::commit();
            return redirect("master-data/master-motor/")->with("success", "Data berhasil ditambahkan!");
        } catch (\Exception $e) {

            $image_path = public_path('motor_images/' . $image_name . '');
            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            DB::rollBack();
            return redirect("master-data/master-motor/")->with("error", "Data gagal ditambahkan! " . $e->getMessage());
        }
    }
}
