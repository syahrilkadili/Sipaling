<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'name'     => 'Administrator',
                'email'    => 'admin@sipaling.ac.id',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ],
            [
                'username' => 'mahasiswa01',
                'name'     => 'Budi Santoso',
                'email'    => 'budi@mahasiswa.ac.id',
                'password' => Hash::make('mahasiswa123'),
                'role'     => 'mahasiswa',
            ],
            [
                'username' => 'petugas01',
                'name'     => 'Pak Suryo',
                'email'    => 'suryo@petugas.ac.id',
                'password' => Hash::make('petugas123'),
                'role'     => 'petugas',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );
        }
    }
}
