<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_debits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_module_penyewaan');
            $table->bigInteger('id_master_motor');
            $table->integer('total_hari_sewa');
            $table->bigInteger('debit');
            $table->bigInteger('total_debit');
            $table->text('remark');
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
        Schema::dropIfExists('log_debits');
    }
}
