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
        Schema::create('soal_kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_id')->constrained('kuis')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->enum('jenis_soal', ['pilihan_ganda', 'benar_salah', 'isian'])->default('pilihan_ganda');
            $table->string('gambar_path')->nullable(); // gambar untuk soal
            $table->string('audio_path')->nullable(); // audio untuk soal listening
            $table->integer('poin')->default(10); // poin untuk soal ini
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_kuis');
    }
};
