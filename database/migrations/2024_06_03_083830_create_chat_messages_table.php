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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("owner_id")->nullable();
            $table->foreignId("chat_id")->nullable();
            $table->text("body");
            $table->timestamps();

            $table->foreign("owner_id")->references("id")->on("users")
                ->onDelete("set null")->onUpdate("cascade");
            $table->foreign("chat_id")->references("id")->on("chats")
                ->onDelete("set null")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
