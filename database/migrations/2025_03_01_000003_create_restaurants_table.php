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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->time('opening_time');
            $table->time('closing_time');
            $table->json('opening_days')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('max_booking_days_ahead')->default(30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
