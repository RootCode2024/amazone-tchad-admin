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
        Schema::create('car_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->references('id')->on('clients')->cascadeOnDelete();
            $table->foreignIdFor(Airport::class, 'place_of_location')->references('id')->on('airports')->cascadeOnDelete();
            $table->date('started_date');
            $table->date('ended_date');
            $table->date('finded_started_date')->nullable();
            $table->date('finded_ended_date')->nullable();
            $table->unsignedBigInteger('finded_price')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedSmallInteger('age');
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_locations');
    }
};
