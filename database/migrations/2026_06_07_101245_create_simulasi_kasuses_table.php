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
        Schema::create('simulasi_kasus', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
            $table->text('skenario');
            $table->string('pertanyaan');
            $table->json('pilihan');
            $table->text('pembahasan');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulasi_kasus');
    }
};
