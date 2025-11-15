<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Materi;
use App\Models\Kuis;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuru = User::whereHas('peran', function($q) {
            $q->where('nama_peran', 'guru');
        })->count();

        $totalSiswa = User::whereHas('peran', function($q) {
            $q->where('nama_peran', 'siswa');
        })->count();

        $totalMateri = Materi::count();
        $totalKuis = Kuis::count();

        return view('superadmin.dashboard', compact(
            'totalGuru',
            'totalSiswa',
            'totalMateri',
            'totalKuis'
        ));
    }
}
