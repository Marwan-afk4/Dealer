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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('developer_id')->constrained()->onDelete('cascade');
            $table->foreignId('uptown_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_person_id')->constrained()->onDelete('cascade');
            $table->foreignId('brocker_id')->constrained()->onDelete('cascade');
            $table->date('brocker_start_date')->Notnulable();
            $table->string('lead_name')->Notnulable();
            $table->date('start_date')->Notnulable();
            $table->date('end_date')->Notnulable();
            $table->enum('status',['closed','pending','lost','in_progress'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
