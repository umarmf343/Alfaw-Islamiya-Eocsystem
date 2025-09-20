<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memorization_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('surah');
            $table->string('ayah_range');
            $table->date('scheduled_for');
            $table->integer('interval')->default(1);
            $table->float('ease_factor')->default(2.5);
            $table->integer('repetitions')->default(0);
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memorization_reviews');
    }
};
