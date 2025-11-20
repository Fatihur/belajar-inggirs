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
        // Add kelas_mengajar to users table for guru
        Schema::table('users', function (Blueprint $table) {
            $table->string('kelas_mengajar')->nullable()->after('kelas')->comment('Kelas yang diajar guru (7 atau 8)');
        });

        // Add kelas_target to materi table
        Schema::table('materi', function (Blueprint $table) {
            $table->string('kelas_target')->nullable()->after('aktif')->comment('Target kelas untuk materi (7 atau 8)');
        });

        // Add kelas_target to kuis table
        Schema::table('kuis', function (Blueprint $table) {
            $table->string('kelas_target')->nullable()->after('tampilkan_jawaban')->comment('Target kelas untuk kuis (7 atau 8)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kelas_mengajar');
        });

        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn('kelas_target');
        });

        Schema::table('kuis', function (Blueprint $table) {
            $table->dropColumn('kelas_target');
        });
    }
};
