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
        Schema::create('application_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('text');

            $table->foreignId('user_id')->nullable();
            $table->foreignId('vacancy_id')->nullable();

            $table->foreign('vacancy_id')->references('id')->on('vacancies')
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
        Schema::dropIfExists('application_comments');
    }
};
