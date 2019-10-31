<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePertanyaanObservasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertanyaan_observasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_kompetensi_id');
            $table->foreign('unit_kompetensi_id')
                    ->references('id')
                    ->on('unit_komepetensi');
            $table->text('pertanyaan');
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
        Schema::dropIfExists('pertanyaan_observasi');
    }
}
