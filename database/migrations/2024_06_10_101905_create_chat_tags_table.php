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
        Schema::create('chat_tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('chat_id')->nullable();
            $table->foreignId('tag_id')->nullable();

            $table->foreign('chat_id')->references('id')->on('chats')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_tags');
    }
};
