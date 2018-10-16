<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKuesionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuesioner', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sertifikat_id')
                ->unsigned();
            $table->foreign('sertifikat_id')
                ->references('id')
                ->on('sertifikat')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('kegiatan_setelah_mendapatkan_sertifikasi');
            $table->text('nama_perusahaan')
                ->nullable();
            $table->text('alamat_perusahaan')
                ->nullable();
            $table->text('jenis_perusahaan')
                ->nullable();
            $table->integer('tahun_memulai_kerja')
                ->nullable();
            $table->text('relevansi_sertifikasi_kompetensi_bidang_dengan_pekerjaan')
                ->nullable();
            $table->text('manfaat_sertifikasi_kompetensi');
            $table->text('saran_perbaikan_untuk_lsp_unesa');
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
        Schema::dropIfExists('kuesioner');
    }
}
