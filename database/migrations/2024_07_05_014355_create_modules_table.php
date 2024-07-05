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
        Schema::create('modules', function (Blueprint $table) {
            $table->string('modulekode',80)->primary();
            $table->string('modulename',150);
            $table->text('moduledesk')->nullable();
            $table->string('moduleurl',255)->nullable();
            $table->string('moduleicon',60)->nullable();
            $table->integer('modulesort')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
