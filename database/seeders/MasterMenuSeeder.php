<?php

namespace Database\Seeders;

use App\Models\MasterMenu;
use Illuminate\Database\Seeder;

class MasterMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterMenu::create([
            'level' => 0,
            'title' => ' Dashboard',
            'code' => 'dashboard',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 0,
            'icon' => 'fa fa-chart-pie'
        ]);
        MasterMenu::create([
            'level' => 0,
            'title' => ' Master Data',
            'code' => 'master-data',
            'is_dropdown' => 1,
            'is_hidden' => 0,
            'priority' => 1,
            'icon' => 'fa fa-sitemap'
        ]);


        MasterMenu::create([
            'level' => 0,
            'title' => ' Module Manajemen',
            'code' => 'module-manajemen',
            'is_dropdown' => 1,
            'is_hidden' => 0,
            'priority' => 2,
            'icon' => 'fa fa-bicycle'
        ]);

        MasterMenu::create([
            'level' => 0,
            'title' => ' Module Cetak Laporan',
            'code' => 'module-print',
            'is_dropdown' => 1,
            'is_hidden' => 0,
            'priority' => 3,
            'icon' => 'fa fa-print'
        ]);

        MasterMenu::create([
            'level' => 2,
            'title' => ' Master Motor',
            'code' => 'master-motor',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 0,
            'icon' => ''
        ]);
        MasterMenu::create([
            'level' => 2,
            'title' => ' Master Penyewa',
            'code' => 'master-penyewa',
            'is_dropdown' => 0,
            'is_hidden' => 1,
            'priority' => 1,
            'icon' => ''
        ]);

        MasterMenu::create([
            'level' => 3,
            'title' => ' Penyewaan',
            'code' => 'module-sewa',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 0,
            'icon' => ''
        ]);
        MasterMenu::create([
            'level' => 3,
            'title' => ' Pengembalian',
            'code' => 'module-kembali',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 1,
            'icon' => ''
        ]);

        MasterMenu::create([
            'level' => 3,
            'title' => ' Administrasi Motor',
            'code' => 'module-administrasi-motor',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 1,
            'icon' => ''
        ]);

        MasterMenu::create([
            'level' => 4,
            'title' => 'Lap. Sewa Harian',
            'code' => 'laporan-sewa-harian',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 0,
            'icon' => ''
        ]);

        MasterMenu::create([
            'level' => 4,
            'title' => 'Lap. Keuangan Kendaran',
            'code' => 'laporan-keuangan-kendaraan',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 0,
            'icon' => ''
        ]);
        MasterMenu::create([
            'level' => 4,
            'title' => 'Lap. Keuangan Bulanan',
            'code' => 'laporan-keuangan-bulanan',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 0,
            'icon' => ''
        ]);

        MasterMenu::create([
            'level' => 4,
            'title' => 'Lap. Akumulasi',
            'code' => 'laporan-akumulasi',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 0,
            'icon' => ''
        ]);
        MasterMenu::create([
            'level' => 4,
            'title' => 'Lap. Total Tiap Bulan',
            'code' => 'laporan-total-tiap-bulan',
            'is_dropdown' => 0,
            'is_hidden' => 0,
            'priority' => 0,
            'icon' => ''
        ]);

    }
}
