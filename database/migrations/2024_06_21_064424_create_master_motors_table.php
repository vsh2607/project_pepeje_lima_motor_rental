<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterMotorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_motors', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('nomor_polisi');
            $table->string('nama_pemilik');
            $table->integer('tahun_pembuatan');
            $table->string('warna_kb');
            $table->string('img_url')->nullable();
            $table->date('tanggal_pajak');
            $table->date('tanggal_pembelian');
            $table->integer('harga_sewa_harian');
            $table->integer('harga_sewa_bulanan');
            $table->integer('status');
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
        Schema::dropDatabaseIfExists('master_motors');
    }
}
