<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('nip',20)->primary();
            $table->string('nama',100);
            $table->string('nik',16)->nullable();
            $table->string('tmp_lahir',60)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('jenis_kelamin',1)->nullable();
            $table->string('deptcode',50);
            $table->string('agama',10)->nullable();
            $table->string('status_nikah',10)->nullable();
            $table->string('pendidikan',10)->nullable();
            $table->string('jurusan',100)->nullable();
            $table->string('alamat_ktp',255)->nullable();
            $table->string('alamat_domisili',255)->nullable();
            $table->string('nama_istri_suami',100)->nullable();
            $table->string('nama_ayah',100)->nullable();
            $table->string('nama_ibu',100)->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->string('jabatan',10)->nullable();
            $table->string('no_hp',16)->nullable();
            $table->string('email',60)->nullable();
            $table->string('status',10)->default('A');
            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->string('deleted_by',20)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('deptcode')
                   ->references('deptcode')
                   ->on('depts')
                   ->onUpdate('NO ACTION')
                   ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
