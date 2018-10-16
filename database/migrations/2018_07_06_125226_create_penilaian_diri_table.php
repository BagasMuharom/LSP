<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaianDiriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_diri', function (Blueprint $table) {
            $table->bigInteger('uji_id')
                ->unsigned()
                ->index();
            $table->foreign('uji_id')
                ->references('id')
                ->on('uji')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('kriteria_id')
                ->unsigned()
                ->index();
            $table->foreign('kriteria_id')
                ->references('id')
                ->on('kriteria')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nilai')
                ->nullable();
            $table->string('bukti')
                ->nullable();
            $table->string('v')
                ->nullable();
            $table->string('a')
                ->nullable();
            $table->string('t')
                ->nullable();
            $table->string('m')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian_diri');
    }
}
