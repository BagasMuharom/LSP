<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skema', function (Blueprint $table) {
            $table->increments('id')
                ->index();
            $table->integer('jenis_id')
                ->unsigned()
                ->nullable()
                ->index();
            $table->foreign('jenis_id')
                ->references('id')
                ->on('jenis')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->integer('tempat_uji_id')
                ->unsigned()
                ->nullable();
            $table->foreign('tempat_uji_id')
                ->references('id')
                ->on('tempat_uji')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->integer('jurusan_id')
                ->unsigned()
                ->nullable()
                ->index();
            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->onUpdate('cascade')
                ->onDelete('set null')
                ->index();
            $table->string('kode')
                ->unique()
                ->index();
            $table->string('nama')
                ->unique()
                ->index();
            $table->string('sektor')
                ->nullable();
            $table->boolean('lintas')
                ->default(true);
            $table->text('keterangan')
                ->nullable();
            $table->bigInteger('harga')
                ->unsigned()
                ->default(0);
            $table->string('kbli');
            $table->string('kbji');
            $table->integer('level_kkni');
            $table->string('kode_unit_skkni');
            $table->string('kualifikasi');
            $table->string('qualification');
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
        Schema::dropIfExists('skema');
    }
}
