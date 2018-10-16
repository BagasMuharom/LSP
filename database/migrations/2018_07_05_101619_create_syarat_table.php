<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyaratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syarat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('skema_id')
                ->unsigned()
                ->index();
            $table->foreign('skema_id')
                ->references('id')
                ->on('skema')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama');
            $table->boolean('upload')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syarat');
    }
}
