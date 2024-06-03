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
        Schema::create('program_school_resumes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('programSchool_id')->nullable();
            $table->foreignId('resume_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');

            $table->foreign('programSchool_id')->references('id')->on('program_schools')
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
        Schema::dropIfExists('program_school_resumes');
    }
};
