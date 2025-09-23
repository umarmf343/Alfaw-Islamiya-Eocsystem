<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recitations', function (Blueprint $table) {
            $table->string('status')->default('processing')->after('hasanat');
        });
    }

    public function down(): void
    {
        Schema::table('recitations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
