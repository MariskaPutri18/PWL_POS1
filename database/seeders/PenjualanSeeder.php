<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Untuk generate kode unik

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'penjualan_id' => $i,
                'user_id' => rand(1, 3), // Random ID user (sesuaikan dengan jumlah user di DB)
                'pembeli' => 'Pembeli ' . $i, // Nama pembeli dummy
                'penjualan_kode' => strtoupper(Str::random(10)), // Generate kode penjualan unik
                'penjualan_tanggal' => now(), // Tanggal penjualan
            ];
        }

        DB::table('m_penjualan')->insert($data);
    }
}
