<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSertifikatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uji_id')
                ->unsigned()
                ->nullable()
                ->index();
            $table->foreign('uji_id')
                ->references('id')
                ->on('uji')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama_pemegang')->nullable();
            $table->integer('skema_id')
                ->nullable()
                ->unsigned();
            $table->foreign('skema_id')
                ->references('id')
                ->on('skema')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('no_urut_cetak');
            $table->integer('tahun_cetak')->nullable();
            $table->string('no_urut_skema');
            $table->integer('tahun');
            $table->date('issue_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->date('tanggal_cetak');
            $table->string('nomor_sertifikat', 50)
                ->nullable()
                ->index()
                ->unique();
            $table->string('nomor_registrasi', 50)
                ->nullable()
                ->index()
                ->unique();
            $table->string('berkas');
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
        Schema::dropIfExists('sertifikat');
    }
}
