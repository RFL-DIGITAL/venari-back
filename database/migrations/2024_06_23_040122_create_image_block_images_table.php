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
        Schema::create('image_block_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('image_id')->nullable();
            $table->foreignId('image_block_id')->nullable();

            $table->foreign('image_id')->references('id')->on('images')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('image_block_id')->references('id')->on('image_blocks')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_block_images');
    }
};
