<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJawabanPertanyaanObservasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_pertanyaan_observasi', function (Blueprint $table) {
            $table->integer('pertanyaan_observasi_id');
            $table->integer('uji_id');
            $table->text('jawaban');
            $table->boolean('memuaskan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_pertanyaan_observasi');
    }
}
