<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'B001', 'barang_nama' => 'Nasi Goreng', 'harga_beli' => 12000, 'harga_jual' => 15000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'B002', 'barang_nama' => 'Mie Ayam', 'harga_beli' => 10000, 'harga_jual' => 12000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'B003', 'barang_nama' => 'Teh Botol', 'harga_beli' => 4000, 'harga_jual' => 5000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'B004', 'barang_nama' => 'Air Mineral', 'harga_beli' => 2500, 'harga_jual' => 3000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'B005', 'barang_nama' => 'Vitamin C', 'harga_beli' => 20000, 'harga_jual' => 25000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'B006', 'barang_nama' => 'Obat Flu', 'harga_beli' => 15000, 'harga_jual' => 18000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'B007', 'barang_nama' => 'Sabun Cuci', 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'B008', 'barang_nama' => 'Sikat Gigi', 'harga_beli' => 4000, 'harga_jual' => 5000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'B009', 'barang_nama' => 'Susu Bayi', 'harga_beli' => 45000, 'harga_jual' => 50000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'B010', 'barang_nama' => 'Popok', 'harga_beli' => 55000, 'harga_jual' => 60000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
