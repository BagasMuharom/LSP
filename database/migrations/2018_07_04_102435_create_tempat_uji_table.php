<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempatUjiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempat_uji', function (Blueprint $table) {
            $table->increments('id')
                ->index();
            $table->string('kode')
                ->unique()
                ->index();
            $table->string('nama');
            $table->integer('jurusan_id')->unsigned();
            $table->foreign('jurusan_id')
                    ->references('id')
                    ->on('jurusan');
            $table->integer('user_id');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempat_uji');
    }
}
