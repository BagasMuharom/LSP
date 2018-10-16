<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('elemen_kompetensi_id')
                ->unsigned()
                ->index();
            $table->foreign('elemen_kompetensi_id')
                ->references('id')
                ->on('elemen_kompetensi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('unjuk_kerja');
            $table->text('pertanyaan');
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
        Schema::dropIfExists('kriteria');
    }
}
