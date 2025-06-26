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
        Schema::create('unit_services', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_unit');
            $table->string('serial_number')->unique();
            $table->string('kerusakan');
            $table->string('kelengkapan');
            $table->foreignId('no_form')
                ->constrained('form_services', 'no_form')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_services');
    }
};
