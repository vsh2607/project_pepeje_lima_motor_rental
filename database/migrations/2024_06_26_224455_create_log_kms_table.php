<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogKmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_kms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_master_motor');
            $table->bigInteger('id_log_target');
            $table->string('type');
            $table->bigInteger('total_km');
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
        Schema::dropIfExists('log_kms');
    }
}
