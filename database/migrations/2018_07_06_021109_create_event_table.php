<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('skema_id')
                ->unsigned()
                ->index();
            $table->foreign('skema_id')
                ->references('id')
                ->on('skema')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('dana_id')
                ->unsigned()
                ->nullable()
                ->index();
            $table->foreign('dana_id')
                ->references('id')
                ->on('dana')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->dateTime('tgl_mulai_pendaftaran');
            $table->dateTime('tgl_akhir_pendaftaran');
            $table->dateTime('tgl_uji');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event');
    }
}
