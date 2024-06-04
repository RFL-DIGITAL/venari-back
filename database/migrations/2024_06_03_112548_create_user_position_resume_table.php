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
        Schema::create('user_position_resume', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('resume_id')->nullable();
            $table->foreignId('user_position_id')->nullable();

            $table->foreign('resume_id')->references('id')->on('resumes')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user_position_id')->references('id')->on('user_positions')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_position_resume');
    }
};
