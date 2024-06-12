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
        Schema::create('application_application_tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('application_id')->nullable();
            $table->foreignId('applicationTag_id')->nullable();

            $table->foreign('application_id')->references('id')->on('applications')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('applicationTag_id')->references('id')->on('application_tags')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_application_tags');
    }
};