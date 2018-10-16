<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyaratUjiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syarat_uji', function (Blueprint $table) {
            $table->integer('syarat_id')
                ->unsigned()
                ->index();
            $table->foreign('syarat_id')
                ->references('id')
                ->on('syarat')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('uji_id')
                ->unsigned()
                ->index();
            $table->foreign('uji_id')
                ->references('id')
                ->on('uji')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syarat_uji');
    }
}
