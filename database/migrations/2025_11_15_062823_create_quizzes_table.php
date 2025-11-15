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
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->foreignId('materi_id')->nullable()->constrained('materi')->onDelete('set null');
            $table->integer('durasi_menit')->default(30); // durasi pengerjaan dalam menit
            $table->integer('nilai_minimal')->default(70); // nilai minimal untuk lulus
            $table->enum('tingkat_kesulitan', ['mudah', 'sedang', 'sulit'])->default('sedang');
            $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('cascade');
            $table->boolean('aktif')->default(true);
            $table->boolean('acak_soal')->default(false); // acak urutan soal
            $table->boolean('tampilkan_jawaban')->default(true); // tampilkan jawaban setelah selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};
