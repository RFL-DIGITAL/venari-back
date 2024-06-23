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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('resume_id')->nullable();
            $table->foreignId('vacancy_id')->nullable();
            $table->foreignId('stage_id')->nullable();

            $table->foreign('stage_id')->references('id')->on('stages')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')
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
        Schema::dropIfExists('applications');
    }
};
