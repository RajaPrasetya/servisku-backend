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
        Schema::create('detail_services', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tgl_masuk');
            $table->timestamp('tgl_selesai')->nullable();
            $table->string('estimasi')->nullable();
            $table->integer('biaya')->default(0);
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
        Schema::dropIfExists('detail_services');
    }
};
