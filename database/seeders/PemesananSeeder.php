<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\Layanan;
use App\Models\Pemesanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key constraint sementara untuk menghindari error
        // jika tabel belum urut dibuat. Hati-hati dengan ini.
        // Schema::disableForeignKeyConstraints(); 
        // Kita tidak gunakan disable constraint karena bisa berbahaya.
        // Pastikan tabel dependensi (pengguna, barbers, layanan) sudah ada dan ter-seed.

        // 1. Pastikan ada data di tabel terkait
        $jumlahPengguna = DB::table('users')->count();
        $jumlahBarber = DB::table('barbers')->count();
        $jumlahLayanan = DB::table('layanans')->count();

        if ($jumlahPengguna == 0 || $jumlahBarber == 0 || $jumlahLayanan == 0) {
            echo "Seeder membutuhkan data di tabel pengguna, barber, dan layanan.\n";
            echo "Silakan jalankan seeder untuk tabel tersebut terlebih dahulu.\n";
            return;
        }

        // 2. Ambil beberapa ID contoh untuk relasi
        $userIds = DB::table('users')->where('role', 'pelanggan')->pluck('id')->toArray();
        $barberIds = DB::table('barbers')->pluck('id')->toArray();
        $layananIds = DB::table('layanans')->pluck('id')->toArray();

        if (empty($userIds) || empty($barberIds) || empty($layananIds)) {
            echo "Seeder membutuhkan minimal satu pelanggan, satu barber, dan satu layanan.\n";
            return;
        }

        // 3. Data contoh untuk pemesanan
        $dataPemesanan = [
            [
                'user_id' => $userIds[array_rand($userIds)],
                'barber_id' => $barberIds[array_rand($barberIds)],
                'tanggal_pemesanan' => Carbon::today()->addDays(rand(0, 5)), // Hari ini hingga 5 hari ke depan
                'waktu_pemesanan' => sprintf('%02d:%02d:00', rand(8, 19), rand(0, 3) * 15), // Jam 08:00 - 19:45, kelipatan 15 menit
                'status' => 'menunggu',
                'catatan' => 'Pelanggan meminta potongan rambut model tertentu.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                // Layanan yang dipilih untuk pemesanan ini (array of layanan_id)
                'layanans' => [
                    $layananIds[array_rand($layananIds)],
                    // Bisa menambahkan lebih dari satu layanan
                    // $layananIds[array_rand($layananIds)],
                ]
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'barber_id' => $barberIds[array_rand($barberIds)],
                'tanggal_pemesanan' => Carbon::today()->addDays(rand(1, 7)),
                'waktu_pemesanan' => sprintf('%02d:%02d:00', rand(9, 18), rand(0, 3) * 15),
                'status' => 'dikonfirmasi',
                'catatan' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDay(),
                'layanans' => [
                    $layananIds[array_rand($layananIds)],
                ]
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'barber_id' => $barberIds[array_rand($barberIds)],
                'tanggal_pemesanan' => Carbon::today()->addDays(rand(2, 10)),
                'waktu_pemesanan' => sprintf('%02d:%02d:00', rand(10, 17), rand(0, 3) * 15),
                'status' => 'dalam_pengerjaan',
                'catatan' => 'Bawa alat cukur sendiri.',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now(),
                'layanans' => [
                    $layananIds[array_rand($layananIds)],
                    $layananIds[array_rand($layananIds)],
                ]
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'barber_id' => $barberIds[array_rand($barberIds)],
                'tanggal_pemesanan' => Carbon::today()->subDays(rand(5, 15)), // Tanggal lalu
                'waktu_pemesanan' => sprintf('%02d:%02d:00', rand(8, 16), rand(0, 3) * 15),
                'status' => 'selesai',
                'catatan' => null,
                'created_at' => Carbon::now()->subWeek(),
                'updated_at' => Carbon::now()->subDays(5),
                'layanans' => [
                    $layananIds[array_rand($layananIds)],
                ]
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'barber_id' => $barberIds[array_rand($barberIds)],
                'tanggal_pemesanan' => Carbon::today()->addDays(rand(3, 8)),
                'waktu_pemesanan' => sprintf('%02d:%02d:00', rand(11, 19), rand(0, 3) * 15),
                'status' => 'dibatalkan',
                'catatan' => 'Berhalangan hadir.',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2),
                'layanans' => [
                    $layananIds[array_rand($layananIds)],
                    $layananIds[array_rand($layananIds)],
                    $layananIds[array_rand($layananIds)],
                ]
            ],
        ];

        // 4. Masukkan data pemesanan dan buat relasi
        foreach ($dataPemesanan as $data) {
            // Pisahkan data layanan
            $layanans = $data['layanans'];
            unset($data['layanans']); // Hapus dari array utama sebelum insert

            // Masukkan data pemesanan
            $pemesananId = DB::table('pemesanans')->insertGetId($data);

            // Masukkan relasi ke tabel pivot pemesanan_layanan
            $pivotData = [];
            foreach ($layanans as $layananId) {
                $pivotData[] = [
                    'pemesanan_id' => $pemesananId,
                    'layanan_id' => $layananId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            if (!empty($pivotData)) {
                DB::table('pemesanan_layanan')->insert($pivotData);
            }

            // 5. Buat transaksi terkait (opsional, tapi bagus untuk data contoh)
            // Hitung total harga dari layanan yang dipilih
            $totalHarga = DB::table('layanans')
                ->whereIn('id', $layanans)
                ->sum('harga');

            DB::table('transaksis')->insert([
                'pemesanan_id' => $pemesananId,
                'user_id' => $data['user_id'], // Sesuaikan dengan nama kolom
                'jumlah' => $totalHarga,
                'status_pembayaran' => $this->getPaymentStatus($data['status']), // Logika sederhana
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }

        echo "Seeder Pemesanan, PemesananLayanan, dan Transaksi berhasil dijalankan.\n";
    }

    /**
     * Menentukan status pembayaran berdasarkan status pemesanan.
     * Ini adalah logika sederhana untuk contoh data.
     */
    private function getPaymentStatus($statusPemesanan)
    {
        switch ($statusPemesanan) {
            case 'selesai':
                return 'dibayar';
            case 'dibatalkan':
                return 'gagal';
            default:
                return 'menunggu';
        }
    }
}
