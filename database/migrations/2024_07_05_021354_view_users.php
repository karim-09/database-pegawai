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
        DB::statement("CREATE VIEW view_users
        AS
        SELECT t1.id,t1.name,t1.username,t1.email,t1.password,t1.profile_photo_path,t1.role_id,t2.rolename,t2.modulelists,t1.email_verified_at,t1.two_factor_secret,t1.two_factor_recovery_codes,t1.remember_token,t1.created_by,t1.updated_by,t1.deleted_by,t1.deleted_at,t1.created_at,t1.updated_at
        FROM
        users t1 
        LEFT JOIN roles t2 ON t2.id = t1.role_id");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW view_users");
    }
};
