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
        Schema::create('language_levels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('language_id')->nullable();
            $table->foreignId('level_id')->nullable();

            $table->foreign('level_id')->references('id')->on('levels')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('language_id')->references('id')->on('languages')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_levels');
    }
};
