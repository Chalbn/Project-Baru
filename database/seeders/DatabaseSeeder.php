<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@sekolah.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Guru
        $guru = User::create([
            'name' => 'Bpk. Budi Santoso',
            'email' => 'guru@sekolah.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'guru',
        ]);

        // Siswa
        User::create([
            'name' => 'Siswa Teladan',
            'email' => 'siswa@sekolah.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'siswa',
        ]);

        // Mata Pelajaran
        \App\Models\Subject::create([
            'name' => 'Matematika Wajib',
            'teacher_id' => $guru->id,
        ]);
    }
}
