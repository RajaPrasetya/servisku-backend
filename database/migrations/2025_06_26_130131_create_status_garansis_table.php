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
        Schema::create('status_garansis', function (Blueprint $table) {
            $table->id();
            $table->boolean('garansi')->default(false);
            $table->timestamp('tgl_beli');
            $table->string('no_nota');
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
        Schema::dropIfExists('status_garansis');
    }
};
