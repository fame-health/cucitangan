<?php

namespace Database\Seeders;

use App\Models\Nurse;
use App\Models\Room;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rooms = [
            ['nama_ruangan' => 'IGD', 'kode_ruangan' => 'IGD', 'keterangan' => 'Instalasi Gawat Darurat'],
            ['nama_ruangan' => 'Rawat Inap', 'kode_ruangan' => 'RIN', 'keterangan' => 'Area rawat inap'],
            ['nama_ruangan' => 'Poli Umum', 'kode_ruangan' => 'POL', 'keterangan' => 'Area poli umum'],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['kode_ruangan' => $room['kode_ruangan']],
                $room,
            );
        }

        $shifts = [
            ['nama_shift' => 'Pagi', 'jam_mulai' => '07:00:00', 'jam_selesai' => '14:00:00'],
            ['nama_shift' => 'Sore', 'jam_mulai' => '14:00:00', 'jam_selesai' => '21:00:00'],
            ['nama_shift' => 'Malam', 'jam_mulai' => '21:00:00', 'jam_selesai' => '07:00:00'],
        ];

        foreach ($shifts as $shift) {
            Shift::updateOrCreate(
                ['nama_shift' => $shift['nama_shift']],
                $shift,
            );
        }

        User::updateOrCreate(
            ['email' => 'admin@cucitangan.test'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        );

        $perawat = User::updateOrCreate(
            ['email' => 'perawat@cucitangan.test'],
            [
                'name' => 'Perawat',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'perawat',
            ],
        );

        Nurse::updateOrCreate(
            ['user_id' => $perawat->id],
            [
                'nama' => 'Perawat',
                'nip' => 'PRW-001',
                'jenis_kelamin' => 'P',
                'no_hp' => '081234567890',
                'alamat' => 'Rumah Sakit Cuci Tangan',
            ],
        );
    }
}
