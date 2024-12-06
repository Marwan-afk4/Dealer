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
        Schema::table('training_subscriptions', function (Blueprint $table) {
            $table->enum('status', ['approved', 'pending'])->default('pending')->after('experience_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_subscriptions', function (Blueprint $table) {
            //
        });
    }
};
