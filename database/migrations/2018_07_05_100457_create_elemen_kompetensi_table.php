<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElemenKompetensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elemen_kompetensi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_kompetensi_id')
                ->unsigned()
                ->index();
            $table->foreign('unit_kompetensi_id')
                ->references('id')
                ->on('unit_kompetensi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama');
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
        Schema::dropIfExists('elemen_kompetensi');
    }
}
