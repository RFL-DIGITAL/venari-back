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
        Schema::create('company_chats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("company_id")->nullable();
            $table->foreignId("user_id")->nullable();

            $table->foreign("user_id")->references("id")->on("users")
                ->onDelete("set null")->onUpdate("cascade");
            $table->foreign("company_id")->references("id")->on("companies")
                ->onDelete("set null")->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_chats');
    }
};
