<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            [
            'username' => 'customer',
            'email' => 'customer@gmail.com',
            'telepon' => '0313011146',
            'alamat' => 'Bangkalan',
            'tanggal_lahir' => '2002-02-02',
            'image' => '',
            'password' => Hash::make('123456'),
            ]
        ]);
        DB::table('admins')->insert([
            [
                'username' => '',
                'email' => 'admin@gmail.com',
                'telepon' => '',
                'alamat' => '',
                'tanggal_lahir' => '2000-01-01',
                'image' => '',
                'password' => Hash::make('123456'),
            ]
        ]);
        DB::table('aboutuss')->insert([
            [
            'site_title' => '',
            'site_about' => '',
            'deskripsi' => '',
            ]
        ]);
        DB::table('rooms')->insert([
            [
            'jenis_kamar' => 'Kamar Ekonomi',
            'harga' => '175000',
            'tamu_dewasa' => '1',
            'tamu_anak' => '1',
            'deskripsi' => '...',
            'image' => 'kamarekonomi.jpeg',
            'tersedia' => '5',
            'status' => 'aktif',
        ],
        [
            'jenis_kamar' => 'Kamar Standar',
            'harga' => '200000',
            'tamu_dewasa' => '1',
            'tamu_anak' => '1',
            'deskripsi' => '...',
            'image' => 'kamarstandard.jpeg',
            'tersedia' => '5',
            'status' => 'aktif',
        ],
        [
            'jenis_kamar' => 'Kamar VIP',
            'harga' => '250000',
            'tamu_dewasa' => '1',
            'tamu_anak' => '1',
            'deskripsi' => '...',
            'image' => 'kamarvip.jpeg',
            'tersedia' => '5',
            'status' => 'aktif',
            ]
        ]);
        DB::table('aboutcontacts')->insert([
            [
            'alamat' => '',
            'maps' => '',
            'telepon' => '',
            'telepon_rujukan' => '',
            'email' => '',
            'email_rujukan' => '',
            'media_sosial' => '',
            'medsos_rujukan' => '',
            'iframe' => '',
            ]
        ]);
    }
}
