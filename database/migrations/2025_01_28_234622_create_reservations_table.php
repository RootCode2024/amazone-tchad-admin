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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('origin');
            $table->string('destination');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->integer('passengers');
            $table->string('email');
            $table->string('telephone');
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
