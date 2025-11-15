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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('peran_id')->after('email')->constrained('peran')->onDelete('cascade');
            $table->string('nomor_induk')->nullable()->after('peran_id'); // NIP untuk guru, NIS untuk siswa
            $table->string('kelas')->nullable()->after('nomor_induk'); // untuk siswa
            $table->text('alamat')->nullable()->after('kelas');
            $table->string('no_telepon')->nullable()->after('alamat');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('no_telepon');
            $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['peran_id']);
            $table->dropColumn(['peran_id', 'nomor_induk', 'kelas', 'alamat', 'no_telepon', 'jenis_kelamin', 'tanggal_lahir']);
        });
    }
};
