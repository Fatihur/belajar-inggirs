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
        Schema::create('kosakata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')->constrained('materi')->onDelete('cascade');
            $table->string('kata_inggris');
            $table->string('kata_indonesia');
            $table->string('jenis_kata')->nullable(); // noun, verb, adjective, dll
            $table->text('contoh_kalimat')->nullable();
            $table->string('audio_path')->nullable(); // path file audio pelafalan
            $table->string('gambar_path')->nullable(); // path gambar ilustrasi
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kosakata');
    }
};
