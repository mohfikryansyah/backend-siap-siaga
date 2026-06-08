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
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('keluarga_id')->constrained('keluargas')->cascadeOnDelete();

            // Tanggal minggu monitoring (awal minggu, misal Senin)
            $table->date('tanggal_minggu');

            // Mood: 1–5 (1=sangat buruk, 5=sangat baik)
            $table->unsignedTinyInteger('mood'); // 1-5

            // Interaksi sosial: 1–5 (1=sangat kurang, 5=sangat aktif)
            $table->unsignedTinyInteger('interaksi_sosial'); // 1-5

            // Tidur: rata-rata jam tidur per malam (misal 4.5, 8.0)
            $table->decimal('tidur', 3, 1); // 1.0 - 12.0

            // Aktivitas: 1–5 (1=tidak aktif, 5=sangat aktif)
            $table->unsignedTinyInteger('aktivitas'); // 1-5

            // Catatan tambahan (opsional)
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Satu anggota keluarga hanya bisa punya 1 monitoring per minggu
            $table->unique(['keluarga_id', 'tanggal_minggu'], 'unique_keluarga_minggu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};
