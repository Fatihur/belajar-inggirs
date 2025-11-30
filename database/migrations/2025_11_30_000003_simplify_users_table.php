<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom yang sudah dipindahkan ke tabel siswa dan guru
            $table->dropColumn([
                'nomor_induk',
                'kelas',
                'kelas_mengajar',
                'alamat',
                'no_telepon',
                'jenis_kelamin',
                'tanggal_lahir'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomor_induk')->nullable()->after('peran_id');
            $table->string('kelas')->nullable()->after('nomor_induk');
            $table->string('kelas_mengajar')->nullable()->after('kelas');
            $table->text('alamat')->nullable()->after('kelas_mengajar');
            $table->string('no_telepon')->nullable()->after('alamat');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('no_telepon');
            $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
        });
    }
};
