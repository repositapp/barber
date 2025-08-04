<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesanan_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            // Kolom tambahan jika diperlukan, misalnya kuantitas, catatan per layanan
            // $table->integer('kuantitas')->default(1);
            // $table->text('catatan')->nullable();
            $table->timestamps();

            // Menambahkan indeks unik untuk mencegah duplikasi
            $table->unique(['pemesanan_id', 'layanan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_layanan');
    }
};
