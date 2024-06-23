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
        Schema::create('language_level_resumes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('language_level_id')->nullable();
            $table->foreignId('resume_id')->nullable();

            $table->foreign('language_level_id')->references('id')->on('language_levels')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('resume_id')->references('id')->on('resumes')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_level_resumes');
    }
};
