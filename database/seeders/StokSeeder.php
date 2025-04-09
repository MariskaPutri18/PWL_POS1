<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'barang_id' => rand(1, 10), // Random barang_id
                'user_id' => rand(1, 3), // Random user_id
                'stok_tanggal' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                'stok_jumlah' => rand(10, 100),
            ];
        }

        DB::table('t_stok')->insert($data);
    }
}
