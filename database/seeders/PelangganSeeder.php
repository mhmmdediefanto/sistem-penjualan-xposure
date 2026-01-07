<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Default User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $pelanggans = [
            [
                'nama' => 'Pelanggan Satu',
                'telepon' => '08123456789',
                'alamat' => 'Jakarta',
            ],
            [
                'nama' => 'Pelanggan Dua',
                'telepon' => '08987654321',
                'alamat' => 'Bandung',
            ],
        ];

        foreach ($pelanggans as $pelanggan) {
            Pelanggan::create(array_merge($pelanggan, [
                'user_id' => $user->id,
            ]));
        }
    }
}

