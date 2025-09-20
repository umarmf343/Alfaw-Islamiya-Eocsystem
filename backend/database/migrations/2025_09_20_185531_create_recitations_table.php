<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assignment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('surah');
            $table->string('ayah_range');
            $table->string('audio_path');
            $table->string('audio_feedback_path')->nullable();
            $table->text('expected_text');
            $table->json('feedback')->nullable();
            $table->float('score')->nullable();
            $table->unsignedInteger('hasanat')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recitations');
    }
};
