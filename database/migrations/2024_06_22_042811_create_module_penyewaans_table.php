<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulePenyewaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_penyewaans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_master_motor');
            $table->string('nama_penyewa');
            $table->string('kontak_penyewa');
            $table->string('jaminan'); // KTP / KTM / Lainnya
            $table->string('jaminan_img');  //Foto Jaminan
            $table->string('jenis_penyewaan'); // harian / bulanan
            $table->date('tanggal_penyewaan');
            $table->date('tanggal_pengembalian')->nullable();
            $table->integer('status'); // 1 : Peminjaman Aktif. 0 Motor Sdh kembali
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_penyewaans');
    }
}
