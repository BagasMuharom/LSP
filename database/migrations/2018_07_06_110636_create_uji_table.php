<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUjiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uji', function (Blueprint $table) {
            $table->bigIncrements('id')
                ->index();
            $table->string('nim', 11)
                ->index();
            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('event_id')
                ->unsigned()
                ->index();
            $table->date('tanggal_uji')
                ->nullable();
            $table->foreign('event_id')
                ->references('id')
                ->on('event')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('admin_id')
                ->unsigned()
                ->nullable()
                ->index();
            $table->foreign('admin_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->integer('bag_sertifikasi_id')
                ->unsigned()
                ->nullable()
                ->index();
            $table->foreign('bag_sertifikasi_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->boolean('terverifikasi_admin')
                ->nullable();
            $table->boolean('terverifikasi_bag_sertifikasi')
                ->nullable();
            $table->string('catatan')
                ->nullable();
            $table->boolean('konfirmasi_penilaian_asesor')
                ->default(false);
            $table->boolean('konfirmasi_asesmen_diri')
                ->default(false);
            $table->text('umpan_balik')
                ->default('')
                ->nullable();
            $table->text('identifikasi_kesenjangan')
                ->default('')
                ->nullable();
            $table->text('saran_tindak_lanjut')
                ->default('')
                ->nullable();
            $table->text('rekomendasi_asesor')
                ->default('')
                ->nullable();
            $table->text('rekomendasi_asesor_asesmen_diri')
                ->default('')
                ->nullable();
            $table->text('catatan_asesmen_diri')
                ->default('')
                ->nullable();
            $table->text('ttd_peserta')
                ->nullable();
            $table->boolean('tidak_melanjutkan_asesmen')
                ->default(false);
            $table->timestamps();
            $table->json('helper');
            $table->boolean('lulus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uji');
    }
}
