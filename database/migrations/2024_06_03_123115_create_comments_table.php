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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('text');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('post_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('post_id')->references('id')->on('posts')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
