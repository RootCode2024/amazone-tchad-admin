<?php

use App\Models\Airport;
use App\Models\Client;
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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->references('id')->on('clients')->cascadeOnDelete();
            $table->foreignIdFor(Airport::class, 'country_id')->references('id')->on('airports')->cascadeOnDelete();
            $table->date('arrival_date');
            $table->date('return_date');
            $table->date('finded_arrival_date')->nullable();
            $table->date('finded_return_date')->nullable();
            $table->unsignedBigInteger('finded_price')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedSmallInteger('number_of_room');
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
