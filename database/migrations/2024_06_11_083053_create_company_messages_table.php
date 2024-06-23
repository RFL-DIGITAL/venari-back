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
        Schema::create('company_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("owner_id")->nullable();
            $table->foreignId("companyChat_id")->nullable();
            $table->text("body")->nullable();
            $table->timestamps();

            $table->foreign("owner_id")->references("id")->on("users")
                ->onDelete("set null")->onUpdate("cascade");
            $table->foreign("companyChat_id")->references("id")->on("company_chats")
                ->onDelete("set null")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_messages');
    }
};
