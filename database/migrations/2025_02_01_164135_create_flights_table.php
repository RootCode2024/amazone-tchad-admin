<?php

use App\Models\Client;
use App\Models\Airport;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->references('id')->on('clients')->cascadeOnDelete();
            $table->enum('flight_type', ['one-way', 'round-trip', 'multi-destination'])->default('one-way');
            $table->foreignIdFor(Airport::class, 'origin')->references('id')->on('airports')->cascadeOnDelete();
            $table->foreignIdFor(Airport::class, 'destination')->references('id')->on('airports')->cascadeOnDelete();
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->integer('passengers');
            $table->enum('flight_class', ['economy', 'premium', 'business'])->default('economy');
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
