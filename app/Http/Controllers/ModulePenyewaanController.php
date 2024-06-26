<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\MasterMotor;
use Illuminate\Http\Request;
use App\Models\ModulePenyewaan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ModulePenyewaanController extends Controller
{
    public function index()
    {
        return view('module-penyewaan.index');
    }

    public function listData()
    {
        $model = ModulePenyewaan::with(['motor'])->orderBy('module_penyewaans.created_at', 'desc');

        return DataTables::of($model)
            ->addColumn('harga_sewa', function ($model) {
                if ($model->jenis_penyewaan == 'harian') {
                    return 'Rp. ' . number_format($model->motor->harga_sewa_harian, 0, ',', '.');
                }
                return 'Rp. ' . number_format($model->motor->harga_sewa_bulanan, 0, ',', '.');
            })
            ->addColumn('total_sewa', function ($model) {
                $tanggal_penyewaan = new DateTime($model->tanggal_penyewaan);
                if ($model->tanggal_pengembalian != null) {
                    //Ini kalau sdh kembali
                    $tanggal_hari_ini = new DateTime($model->tanggal_pengembalian);
                } else {
                    $tanggal_hari_ini = new DateTime();
                }
                $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;

                if ($model->jenis_penyewaan == 'harian') {
                    $interval = $tanggal_hari_ini->diff($tanggal_penyewaan);
                    $interval = $interval->days;
                    $interval <= 0 ? $total_sewa = $model->motor->harga_sewa_harian : $total_sewa = $model->motor->harga_sewa_harian * $interval;
                } else {
                    $interval = $tanggal_hari_ini->diff($tanggal_penyewaan);
                    $interval = $interval->days;
                    $interval <= 0 ? $total_sewa = $model->motor->harga_sewa_harian : $total_sewa = $model->motor->harga_sewa_harian * $interval;
                }
                return 'Rp. ' . number_format($total_sewa, 0, ',', '.');
            })
            ->editColumn('status', function ($model) {
                $status = $model->status == 1 ? "<span class='badge badge-warning'>Masih Dipinjam</span>" : "<span class='badge badge-success'>Sudah Dikembalikan</span>";
                return $status;
            })
            ->addColumn('action', function ($model) {
                $infoButton = "<a href='" . url('module-manajemen/module-sewa/' . $model->id . '/info') . "' class='btn  btn-primary d-inline-block'><i class='fas fa-info'></i></a>";
                $editButton = "&nbsp;<a href='" . url('module-manajemen/module-sewa/' . $model->id . '/edit') . "' class='btn  btn-warning d-inline-block'><i class='fas fa-edit'></i></a>";
                $deleteButton = "&nbsp;<a href='#' class='btn  btn-danger d-inline-block'><i class='fas fa-trash'></i></a>";
                if ($model->status == 0) {
                    return $infoButton;
                }
                return $infoButton . $editButton;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    public function viewForm($id)
    {
        $data = ModulePenyewaan::with(['motor'])->where('id', $id)->first();

        $tanggal_penyewaan = new DateTime($data->tanggal_penyewaan);
        if ($data->tanggal_pengembalian != null) {
            //Ini kalau sdh kembali
            $tanggal_hari_ini = new DateTime($data->tanggal_pengembalian);
        } else {
            $tanggal_hari_ini = new DateTime();
        }
        $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;

        if ($data->jenis_penyewaan == 'harian') {
            $interval = $tanggal_hari_ini->diff($tanggal_penyewaan);
            $interval = $interval->days;
            $interval <= 0 ? $total_sewa = $data->motor->harga_sewa_harian : $total_sewa = $data->motor->harga_sewa_harian * $interval;
        } else {
            $interval = $tanggal_hari_ini->diff($tanggal_penyewaan);
            $interval = $interval->days;
            $interval <= 0 ? $total_sewa = $data->motor->harga_sewa_harian : $total_sewa = $data->motor->harga_sewa_harian * $interval;
        }

        $total_sewa = 'Rp. ' . number_format($total_sewa, 0, ',', '.');

        return view('module-penyewaan.info', ['data' => $data, 'total_hari_sewa' => $interval, 'total_biaya_sewa' => $total_sewa]);
    }


    public function addForm()
    {
        return view('module-penyewaan.add');
    }


    public function editForm($id)
    {
        $data = ModulePenyewaan::with(['motor'])->where('id', $id)->first();
        $tanggal_penyewaan = new DateTime($data->tanggal_penyewaan);
        if ($data->tanggal_pengembalian != null) {
            //Ini kalau sdh kembali
            $tanggal_hari_ini = new DateTime($data->tanggal_pengembalian);
        } else {
            $tanggal_hari_ini = new DateTime();
        }
        $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;

        if ($data->jenis_penyewaan == 'harian') {
            $interval = $tanggal_hari_ini->diff($tanggal_penyewaan);
            $interval = $interval->days;
            $interval <= 0 ? $total_sewa = $data->motor->harga_sewa_harian : $total_sewa = $data->motor->harga_sewa_harian * $interval;
        } else {
            $interval = $tanggal_hari_ini->diff($tanggal_penyewaan);
            $interval = $interval->days;
            $interval <= 0 ? $total_sewa = $data->motor->harga_sewa_harian : $total_sewa = $data->motor->harga_sewa_harian * $interval;
        }

        $total_sewa = 'Rp. ' . number_format($total_sewa, 0, ',', '.');

        return view('module-penyewaan.edit', ['data' => $data, 'total_hari_sewa' => $interval, 'total_biaya_sewa' => $total_sewa]);
    }

    public function updateData(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = ModulePenyewaan::with(['motor'])->where('id', $id)->first();


            if ($request->input('jaminan_img') != null) {
                $image_data = $request->input('jaminan_img');
                list(, $image_data)      = explode(',', $image_data);
                $image_data = base64_decode($image_data);
                $image_name = time() . '_' .  $request->jaminan . '_' . $request->nama_penyewa . '.png';
                $path = public_path('jaminan_images/' . $image_name);
                file_put_contents($path, $image_data);


                $image_path = public_path('jaminan_images/' . $data->jaminan_img);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $data->update([
                'id_master_motor' => $request->input('id_master_motor'),
                'nama_penyewa' => $request->input('nama_penyewa'),
                'kontak_penyewa' => $request->input('kontak_penyewa'),
                'jaminan' => $request->input('jaminan'),
                'jaminan_img' => $request->input('jaminan_img') != null ? $image_name : $data->jaminan_img,
                'jenis_penyewaan' => $request->input('jenis_penyewaan'),
                'tanggal_penyewaan' => $request->input('tanggal_penyewaan'),

            ]);

            $dataMotorPinjamanSebelumnya = MasterMotor::where('id', $data->motor->id)->first();
            $dataMotorPinjamanSebelumnya->update([
                'status' => 1
            ]);
            $dataMotor = MasterMotor::where('id', $request->id_master_motor)->first();
            $dataMotor->update([
                'status' => 0
            ]);

            DB::commit();
            return redirect("module-manajemen/module-sewa/$id/edit")->with("success", "Data berhasil diubah!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("module-manajemen/module-sewa/$id/edit")->with("error", "Data gagal diubah! " . $e->getMessage());
        }
    }

    public function addData(Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request->input('jaminan_img') != null) {
                $image_data = $request->input('jaminan_img');
                list(, $image_data)      = explode(',', $image_data);
                $image_data = base64_decode($image_data);
                $image_name = time() . '_' .  $request->jaminan . '_' . $request->nama_penyewa . '.png';
                $path = public_path('jaminan_images/' . $image_name);
                file_put_contents($path, $image_data);
            }

            ModulePenyewaan::create([
                'id_master_motor' => $request->input('id_master_motor'),
                'nama_penyewa' => $request->input('nama_penyewa'),
                'kontak_penyewa' => $request->input('kontak_penyewa'),
                'jaminan' => $request->input('jaminan'),
                'jaminan_img' => $request->input('jaminan_img') != null ? $image_name : '',
                'jenis_penyewaan' => $request->input('jenis_penyewaan'),
                'tanggal_penyewaan' => $request->input('tanggal_penyewaan'),
                'status' => 1
            ]);

            $dataMotor = MasterMotor::where('id', $request->id_master_motor)->first();
            $dataMotor->update([
                'status' => 0
            ]);

            DB::commit();
            return redirect("module-manajemen/module-sewa/")->with("success", "Data berhasil ditambahkan!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("module-manajemen/module-sewa/")->with("error", "Data gagal ditambahkan! " . $e->getMessage());
        }
    }

    public function dataPenyewaan(Request $request)
    {
        $requestData = $request->all();

        if ($requestData["id_nomor_polisi"] != null) {
            $data = ModulePenyewaan::with(['motor'])->whereHas('motor', function ($query) use ($requestData) {
                $query->where('id', $requestData["id_nomor_polisi"]);
            })->where('status', 1)->first();
        }
        $tanggal_penyewaan = new DateTime($data->tanggal_penyewaan);
        $tanggal_hari_ini = new DateTime();
        $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;

        if ($data->jenis_penyewaan == 'harian') {
            $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;
            $total_sewa = $interval <= 0 ? $data->motor->harga_sewa_harian : $data->motor->harga_sewa_harian * $interval;
        } else {
            $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;
            $total_sewa = $interval <= 0 ? $data->motor->harga_sewa_harian : $data->motor->harga_sewa_harian * $interval;
        }
        $total_sewa = 'Rp. ' . number_format($total_sewa, 0, ',', '.');
        $mergedData = [
            'data' => $data,
            'total_sewa' => $total_sewa,
            'interval' => $interval
        ];
        return response()->json($mergedData);
    }
}
