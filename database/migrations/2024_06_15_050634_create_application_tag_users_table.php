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
        Schema::create('application_tag_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('application_tag_id')->nullable();
            $table->foreignId('user_id')->nullable();

            $table->foreign('application_tag_id')->references('id')->on('application_tags')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_tag_users');
    }
};
