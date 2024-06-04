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
        Schema::create('program_schools', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('program_id')->nullable();
            $table->foreignId('school_id')->nullable();

            $table->foreign('program_id')->references('id')->on('programs')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('school_id')->references('id')->on('schools')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_schools');
    }
};
