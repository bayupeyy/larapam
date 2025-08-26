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
    Schema::create('patrol_points', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama checkpoint
        $table->text('location')->nullable(); // Lokasi detail
        $table->uuid('qr_code')->unique(); // Kode unik
        $table->string('qr_code_path')->nullable(); // Path file QR disimpan
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrol_points');
    }
};
