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
        Schema::create('depts', function (Blueprint $table) {
            $table->string('deptcode',50)->primary();
            $table->string('deptperent',50)->nullable();
            $table->string('deptname',150);
            $table->string('deptemail',150)->unique();
            $table->string('depttelp',20)->nullable();
            $table->text('deptaddress')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depts');
    }
};
