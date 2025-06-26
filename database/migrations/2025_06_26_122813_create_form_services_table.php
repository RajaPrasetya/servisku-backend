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
        Schema::create('form_services', function (Blueprint $table) {
            $table->id('no_form');
            $table->enum('status', ['diterima', 'proses', 'selesai'])->default('diterima');
            $table->timestamps();
            $table->foreignId('id_customer')->constrained('customers', 'id_customer')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_services');
    }
};
