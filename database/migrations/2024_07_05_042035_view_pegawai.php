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
        DB::statement("CREATE VIEW view_pegawai
        AS
        SELECT t1.nip,t1.nama,t1.nik,t1.tmp_lahir,t1.tgl_lahir,t1.jenis_kelamin,t8.jenis_kelamin_nama,t1.deptcode,t2.deptname,t1.agama,t3.agama_nama,t1.status_nikah,t4.status_nikah_nama,t1.pendidikan,t5.pendidikan_nama,t1.jurusan,t1.alamat_ktp,t1.alamat_domisili,t1.nama_istri_suami,t1.nama_ayah,t1.nama_ibu,t1.tgl_masuk,t1.jabatan,t6.jabatan_nama,t1.no_hp,t1.email,t1.status,t7.status_nama,
        t1.created_by,t1.updated_by,t1.deleted_by,t1.created_at,t1.updated_at
        FROM
        pegawai t1 
        LEFT JOIN depts t2 ON t2.deptcode = t1.deptcode
        LEFT JOIN (SELECT j.kode,j.nama as agama_nama FROM ms_options j WHERE j.untuk='agama' ORDER BY j.id) as t3 ON t3.kode=t1.agama
        LEFT JOIN (SELECT j.kode,j.nama as status_nikah_nama FROM ms_options j WHERE j.untuk='statusnikah' ORDER BY j.id) as t4 ON t4.kode=t1.status_nikah
        LEFT JOIN (SELECT j.kode,j.nama as pendidikan_nama FROM ms_options j WHERE j.untuk='pendidikan' ORDER BY j.id) as t5 ON t5.kode=t1.pendidikan
        LEFT JOIN (SELECT j.kode,j.nama as jabatan_nama FROM ms_options j WHERE j.untuk='jabatan' ORDER BY j.id) as t6 ON t6.kode=t1.jabatan
        LEFT JOIN (SELECT j.kode,j.nama as status_nama FROM ms_options j WHERE j.untuk='statuspegawai' ORDER BY j.id) as t7 ON t7.kode=t1.status
        LEFT JOIN (SELECT j.kode,j.nama as jenis_kelamin_nama FROM ms_options j WHERE j.untuk='jeniskelamin' ORDER BY j.id) as t8 ON t8.kode=t1.jenis_kelamin
        WHERE t1.deleted_at IS NULL
        ORDER BY t1.nip ASC, t1.created_at DESC");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW view_pegawai");
    }
};
