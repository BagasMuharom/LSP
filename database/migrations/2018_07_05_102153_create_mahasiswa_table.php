<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim', 11)
                ->unique()
                ->primary()
                ->index();
            $table->integer('prodi_id')
                ->unsigned()
                ->index();
            $table->foreign('prodi_id')
                ->references('id')
                ->on('prodi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nama');
            $table->string('email')
                ->unique()
                ->index();
            $table->string('alamat');
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('no_telepon');
            $table->boolean('terverifikasi')->default(false);
            $table->boolean('terblokir')->default(false);
            $table->text('password');
            $table->string('dir_ktp')->nullable();
            $table->string('dir_foto')->nullable();
            $table->string('dir_transkrip')->nullable();
            $table->string('nik', 16)->unique();
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->string('jenis_kelamin');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
