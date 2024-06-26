<?php

namespace Database\Seeders;

use App\Models\MasterMotor;
use Illuminate\Database\Seeder;

class MasterMotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterMotor::create([
            'name' => 'MIO PUTIH',
            'nomor_polisi' => 'ASD 1233 DS',
            'nama_pemilik' => 'VALENTINO',
            'tahun_pembuatan' => '2020',
            'warna_kb' => 'PUTIH',
            'img_url' => '1.png',
            'tanggal_pajak' => '2024-06-20',
            'tanggal_pembelian' => '2024-06-11',
            'harga_sewa_harian' => 20000,
            'harga_sewa_bulanan' => 100000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'MIO HITAM',
            'nomor_polisi' => 'AB 1234 XY',
            'nama_pemilik' => 'RICKY',
            'tahun_pembuatan' => '2019',
            'warna_kb' => 'HITAM',
            'img_url' => '2.jpeg',
            'tanggal_pajak' => '2024-07-15',
            'tanggal_pembelian' => '2023-05-10',
            'harga_sewa_harian' => 22000,
            'harga_sewa_bulanan' => 110000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'BEAT MERAH',
            'nomor_polisi' => 'CD 2345 YZ',
            'nama_pemilik' => 'ALDI',
            'tahun_pembuatan' => '2018',
            'warna_kb' => 'MERAH',
            'img_url' => '3.jpeg',
            'tanggal_pajak' => '2024-08-12',
            'tanggal_pembelian' => '2022-04-14',
            'harga_sewa_harian' => 23000,
            'harga_sewa_bulanan' => 115000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'VARIO BIRU',
            'nomor_polisi' => 'EF 3456 AB',
            'nama_pemilik' => 'ALICIA',
            'tahun_pembuatan' => '2021',
            'warna_kb' => 'BIRU',
            'img_url' => '4.jpeg',
            'tanggal_pajak' => '2024-09-19',
            'tanggal_pembelian' => '2023-06-15',
            'harga_sewa_harian' => 25000,
            'harga_sewa_bulanan' => 125000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'NMAX SILVER',
            'nomor_polisi' => 'GH 4567 BC',
            'nama_pemilik' => 'RAMA',
            'tahun_pembuatan' => '2020',
            'warna_kb' => 'SILVER',
            'img_url' => '5.jpeg',
            'tanggal_pajak' => '2024-10-22',
            'tanggal_pembelian' => '2021-07-18',
            'harga_sewa_harian' => 27000,
            'harga_sewa_bulanan' => 135000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'PCX GOLD',
            'nomor_polisi' => 'IJ 5678 CD',
            'nama_pemilik' => 'TINA',
            'tahun_pembuatan' => '2022',
            'warna_kb' => 'GOLD',
            'img_url' => '6.jpeg',
            'tanggal_pajak' => '2024-11-25',
            'tanggal_pembelian' => '2022-08-20',
            'harga_sewa_harian' => 28000,
            'harga_sewa_bulanan' => 140000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'LEXI MERAH',
            'nomor_polisi' => 'KL 6789 DE',
            'nama_pemilik' => 'DINA',
            'tahun_pembuatan' => '2019',
            'warna_kb' => 'MERAH',
            'img_url' => '7.jpeg',
            'tanggal_pajak' => '2024-12-30',
            'tanggal_pembelian' => '2020-09-21',
            'harga_sewa_harian' => 21000,
            'harga_sewa_bulanan' => 105000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'AEROX HITAM',
            'nomor_polisi' => 'MN 7890 EF',
            'nama_pemilik' => 'RICO',
            'tahun_pembuatan' => '2018',
            'warna_kb' => 'HITAM',
            'img_url' => '8.jpeg',
            'tanggal_pajak' => '2025-01-05',
            'tanggal_pembelian' => '2019-10-23',
            'harga_sewa_harian' => 24000,
            'harga_sewa_bulanan' => 120000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'VESPA HIJAU',
            'nomor_polisi' => 'OP 8901 FG',
            'nama_pemilik' => 'JACK',
            'tahun_pembuatan' => '2021',
            'warna_kb' => 'HIJAU',
            'img_url' => '9.jpeg',
            'tanggal_pajak' => '2025-02-12',
            'tanggal_pembelian' => '2022-11-24',
            'harga_sewa_harian' => 30000,
            'harga_sewa_bulanan' => 150000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'SUPRA FIT',
            'nomor_polisi' => 'QR 9012 GH',
            'nama_pemilik' => 'ANDI',
            'tahun_pembuatan' => '2017',
            'warna_kb' => 'BIRU',
            'img_url' => '10.jpeg',
            'tanggal_pajak' => '2025-03-18',
            'tanggal_pembelian' => '2021-12-25',
            'harga_sewa_harian' => 19000,
            'harga_sewa_bulanan' => 95000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'SONIC PUTIH',
            'nomor_polisi' => 'ST 0123 IJ',
            'nama_pemilik' => 'DARA',
            'tahun_pembuatan' => '2022',
            'warna_kb' => 'PUTIH',
            'img_url' => '11.jpeg',
            'tanggal_pajak' => '2025-04-21',
            'tanggal_pembelian' => '2022-01-27',
            'harga_sewa_harian' => 32000,
            'harga_sewa_bulanan' => 160000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'CBR 150',
            'nomor_polisi' => 'UV 2345 KL',
            'nama_pemilik' => 'GILANG',
            'tahun_pembuatan' => '2020',
            'warna_kb' => 'MERAH',
            'img_url' => '12.jpeg',
            'tanggal_pajak' => '2025-05-25',
            'tanggal_pembelian' => '2022-02-28',
            'harga_sewa_harian' => 34000,
            'harga_sewa_bulanan' => 170000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'CB150R',
            'nomor_polisi' => 'WX 3456 MN',
            'nama_pemilik' => 'HARRY',
            'tahun_pembuatan' => '2018',
            'warna_kb' => 'HITAM',
            'img_url' => '13.jpeg',
            'tanggal_pajak' => '2025-06-29',
            'tanggal_pembelian' => '2019-03-30',
            'harga_sewa_harian' => 35000,
            'harga_sewa_bulanan' => 175000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'TIGER REVO',
            'nomor_polisi' => 'YZ 4567 OP',
            'nama_pemilik' => 'JERRY',
            'tahun_pembuatan' => '2019',
            'warna_kb' => 'SILVER',
            'img_url' => '14.jpeg',
            'tanggal_pajak' => '2025-07-31',
            'tanggal_pembelian' => '2020-04-01',
            'harga_sewa_harian' => 36000,
            'harga_sewa_bulanan' => 180000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'GL PRO',
            'nomor_polisi' => 'BC 5678 QR',
            'nama_pemilik' => 'KELLY',
            'tahun_pembuatan' => '2017',
            'warna_kb' => 'HIJAU',
            'img_url' => '15.jpeg',
            'tanggal_pajak' => '2025-08-15',
            'tanggal_pembelian' => '2021-05-04',
            'harga_sewa_harian' => 17000,
            'harga_sewa_bulanan' => 85000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'WIN 100',
            'nomor_polisi' => 'DE 6789 ST',
            'nama_pemilik' => 'LINDA',
            'tahun_pembuatan' => '2020',
            'warna_kb' => 'MERAH',
            'img_url' => '16.jpeg',
            'tanggal_pajak' => '2025-09-18',
            'tanggal_pembelian' => '2022-06-06',
            'harga_sewa_harian' => 25000,
            'harga_sewa_bulanan' => 125000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'SUPRA X 125',
            'nomor_polisi' => 'FG 7890 UV',
            'nama_pemilik' => 'MIKE',
            'tahun_pembuatan' => '2021',
            'warna_kb' => 'BIRU',
            'img_url' => '17.jpeg',
            'tanggal_pajak' => '2025-10-20',
            'tanggal_pembelian' => '2023-07-07',
            'harga_sewa_harian' => 20000,
            'harga_sewa_bulanan' => 100000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'VERZA 150',
            'nomor_polisi' => 'HI 8901 WX',
            'nama_pemilik' => 'SANDY',
            'tahun_pembuatan' => '2019',
            'warna_kb' => 'HITAM',
            'img_url' => '18.jpeg',
            'tanggal_pajak' => '2025-11-25',
            'tanggal_pembelian' => '2020-08-09',
            'harga_sewa_harian' => 27000,
            'harga_sewa_bulanan' => 135000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'REVO FIT',
            'nomor_polisi' => 'JK 9012 YZ',
            'nama_pemilik' => 'NINA',
            'tahun_pembuatan' => '2018',
            'warna_kb' => 'HIJAU',
            'img_url' => '19.jpeg',
            'tanggal_pajak' => '2025-12-30',
            'tanggal_pembelian' => '2019-09-11',
            'harga_sewa_harian' => 18000,
            'harga_sewa_bulanan' => 90000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);

        MasterMotor::create([
            'name' => 'BEAT STREET',
            'nomor_polisi' => 'LM 0123 AB',
            'nama_pemilik' => 'CARLOS',
            'tahun_pembuatan' => '2021',
            'warna_kb' => 'PUTIH',
            'img_url' => '20.jpeg',
            'tanggal_pajak' => '2026-01-03',
            'tanggal_pembelian' => '2022-10-12',
            'harga_sewa_harian' => 26000,
            'harga_sewa_bulanan' => 130000,
            'status' => 1, 'modal_awal_motor' => rand(2000000, 4000000)
        ]);
    }
}
