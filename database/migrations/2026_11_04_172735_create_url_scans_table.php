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
        Schema::create('url_scans', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->string('domain', 255)->nullable()->index();
            $table->string('status', 30)->index();
            $table->unsignedTinyInteger('total_sources')->default(0);
            $table->unsignedTinyInteger('successful_sources')->default(0);
            $table->unsignedTinyInteger('detected_sources')->default(0);
            $table->json('results')->nullable();
            $table->timestamp('scanned_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_scans');
    }
};
