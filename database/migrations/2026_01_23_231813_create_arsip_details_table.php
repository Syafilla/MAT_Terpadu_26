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
        Schema::create('arsip_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_header_id')->constrained()->cascadeOnDelete();

            $table->string('kode_klasifikasi')->nullable();
            $table->string('indeks')->nullable();
            $table->text('uraian')->nullable();
            $table->string('kurun_waktu')->nullable();
            $table->string('tingkat_perkembangan')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('nomor_definitif')->nullable();
            $table->string('nomor_boks')->nullable();
            $table->string('rak')->nullable();
            $table->string('baris')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_details');
    }
};
