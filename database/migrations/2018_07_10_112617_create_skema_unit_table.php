<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkemaUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skema_unit', function (Blueprint $table) {
            $table->integer('skema_id')
                ->unsigned()
                ->index();
            $table->foreign('skema_id')
                ->references('id')
                ->on('skema')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('unit_kompetensi_id')
                ->unsigned()
                ->index();
            $table->foreign('unit_kompetensi_id')
                ->references('id')
                ->on('unit_kompetensi')
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
        Schema::dropIfExists('skema_unit');
    }
}
