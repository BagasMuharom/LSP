<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswaMandiriEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_mandiri_event', function (Blueprint $table) {
            $table->string('nim', 11);
            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('event_id')
                ->unsigned();
            $table->foreign('event_id')
                ->references('id')
                ->on('event')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_event');
    }
}
