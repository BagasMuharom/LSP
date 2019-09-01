<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MahasiswaTTDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_ttd', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mahasiswa_nim', 11);
            $table->foreign('mahasiswa_nim')
                ->references('nim')
                ->on('mahasiswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('ttd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_ttd');
    }
}
