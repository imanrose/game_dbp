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
        Schema::create('soalan_peribahasas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('klu_soalan');
            $table->string('jawapan_betul');
            $table->string('pilihan_salah_1');
            $table->string('pilihan_salah_2');
            $table->text('maksud_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soalan_peribahasas');
    }
};
