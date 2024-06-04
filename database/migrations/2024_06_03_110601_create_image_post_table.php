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
        Schema::create('image_post', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('image_id')->nullable();
            $table->foreignId('post_id')->nullable();

            $table->foreign('image_id')->references('id')->on('images')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('post_id')->references('id')->on('posts')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_post');
    }
};
