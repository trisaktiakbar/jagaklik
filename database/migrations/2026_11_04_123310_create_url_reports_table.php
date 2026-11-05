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
        Schema::create('url_reports', function (Blueprint $table) {
            $table->id();

            // URL lengkap dan URL utama (domain)
            $table->text('url');
            $table->text('domain_url', 2048);

            // Informasi laporan
            $table->string('category', 50);
            $table->text('description')->nullable();
            $table->string('evidence')->nullable();

            // Informasi pelapor
            $table->string('reporter_name', 100)->nullable();
            $table->string('reporter_email', 150)->nullable();
            $table->string('reporter_ip', 45)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_reports');
    }
};
