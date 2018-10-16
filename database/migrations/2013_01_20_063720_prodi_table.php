<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodi', function (Blueprint $table){
            $table->increments('id');
            $table->string('key')
                ->unique();
            $table->integer('jurusan_id')
                ->unsigned();
            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->string('nama')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
