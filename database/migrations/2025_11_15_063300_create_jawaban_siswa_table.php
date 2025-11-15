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
        Schema::create('jawaban_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('percobaan_id')->constrained('percobaan_kuis')->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('soal_kuis')->onDelete('cascade');
            $table->foreignId('pilihan_jawaban_id')->nullable()->constrained('pilihan_jawaban')->onDelete('set null');
            $table->text('jawaban_isian')->nullable(); // untuk soal isian
            $table->boolean('benar')->default(false);
            $table->integer('poin_didapat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswa');
    }
};
