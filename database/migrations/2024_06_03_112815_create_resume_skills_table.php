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
        Schema::create('resume_skills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('resume_id')->nullable();
            $table->foreignId('skill_id')->nullable();

            $table->foreign('resume_id')->references('id')->on('resumes')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('skill_id')->references('id')->on('skills')
                ->onUpdate('cascade')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_skills');
    }
};
