<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JurusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurusan', function (Blueprint $table){
            $table->increments('id');
            $table->string('key')
                ->unique();
            $table->integer('fakultas_id')->unsigned();
            $table->foreign('fakultas_id')
                ->references('id')
                ->on('fakultas')
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
