<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_menu', function (Blueprint $table) {
            $table->integer('menu_id')
                ->unsigned()
                ->index();
            $table->foreign('menu_id')
                ->references('id')
                ->on('menu')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('role_id')
                ->unsigned()
                ->index();
            $table->foreign('role_id')
                ->references('id')
                ->on('role')
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
        Schema::dropIfExists('role_menu');
    }
}
