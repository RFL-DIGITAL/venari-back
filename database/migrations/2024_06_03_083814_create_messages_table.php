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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("from_id")->nullable();
            $table->foreignId("to_id")->nullable();
            $table->text("body");
            $table->timestamps();

            $table->foreign("from_id")->references("id")->on("users")
                ->onDelete("set null")->onUpdate("cascade");
            $table->foreign("to_id")->references("id")->on("users")
                ->onDelete("set null")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
