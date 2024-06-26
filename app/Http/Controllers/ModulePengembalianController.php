<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\LogDebit;
use App\Models\MasterMotor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ModulePenyewaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ModulePengembalianController extends Controller
{
    public function index()
    {
        return view('module-pengembalian.index');
    }

    public function returnMotor($id)
    {
        DB::beginTransaction();
        try {
            $penyewaan = ModulePenyewaan::with(['motor'])->where('id', $id)->first();

            $penyewaan->update(['status' => 0]);
            MasterMotor::where('id', $penyewaan->motor->id)->update(['status' => 1]);


            $tanggal_penyewaan = new DateTime($penyewaan->tanggal_penyewaan);
            $tanggal_hari_ini = new DateTime();
            $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;

            if ($penyewaan->jenis_penyewaan == 'harian') {
                $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;
                $total_sewa = $interval <= 0 ? $penyewaan->motor->harga_sewa_harian : $penyewaan->motor->harga_sewa_harian * $interval;
            } else {
                $interval = $tanggal_hari_ini->diff($tanggal_penyewaan)->days;
                $total_sewa = $interval <= 0 ? $penyewaan->motor->harga_sewa_harian : $penyewaan->motor->harga_sewa_harian * $interval;
            }

            LogDebit::addDebit($penyewaan, $total_sewa);
            $jaminan_file_path = public_path('/jaminan_images/'.$penyewaan->jaminan_img);
            if(File::exists($jaminan_file_path)){
                File::delete($jaminan_file_path);
            }

            $total_sewa_terbilang = $this->numberToWords($total_sewa);
            $total_sewa = 'Rp. ' . number_format($total_sewa, 0, ',', '.');
            $data = [
                'nama_penyewa' => $penyewaan->nama_penyewa,
                'tot_sewa_terbilang' => $total_sewa_terbilang,
                'nama_motor' => $penyewaan->motor->name,
                'interval' => $interval,
                'tanggal_mulai_sewa' => date('d F y', strtotime($penyewaan->tanggal_penyewaan)),
                'tanggal_akhir_sewa' => date("d F y"),
                'tanggal_cetak_kwitansi' => date('d F Y'),
                'tot_sewa_nominal' => $total_sewa,

            ];

            $pdf = Pdf::loadView('module-pengembalian.kwitansi_page', $data);
            $pdf_name = 'kwitansi sewa ' . $penyewaan->nama_penyewa . '.pdf';


            DB::commit();

            return $pdf->stream($pdf_name);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("/module-penyewaan/module-kembali/")->with("error", "Data gagal ditambahkan! " . $e->getMessage());
        }
    }

    private function numberToWords($number)
    {
        $units = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $result = "";

        if ($number < 12) {
            $result = $units[$number];
        } else if ($number < 20) {
            $result = $units[$number - 10] . " Belas";
        } else if ($number < 100) {
            $result = $units[floor($number / 10)] . " Puluh " . $units[$number % 10];
        } else if ($number < 200) {
            $result = "Seratus " . $this->numberToWords($number - 100);
        } else if ($number < 1000) {
            $result = $units[floor($number / 100)] . " Ratus " . $this->numberToWords($number % 100);
        } else if ($number < 2000) {
            $result = "Seribu " . $this->numberToWords($number - 1000);
        } else if ($number < 1000000) {
            $result = $this->numberToWords(floor($number / 1000)) . " Ribu " . $this->numberToWords($number % 1000);
        } else if ($number < 1000000000) {
            $result = $this->numberToWords(floor($number / 1000000)) . " Juta " . $this->numberToWords($number % 1000000);
        } else if ($number < 1000000000000) {
            $result = $this->numberToWords(floor($number / 1000000000)) . " Miliar " . $this->numberToWords($number % 1000000000);
        } else if ($number < 1000000000000000) {
            $result = $this->numberToWords(floor($number / 1000000000000)) . " Triliun " . $this->numberToWords($number % 1000000000000);
        }
        return trim($result);
    }
}
