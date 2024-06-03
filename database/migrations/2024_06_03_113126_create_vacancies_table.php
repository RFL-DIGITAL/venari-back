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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('company_id')->nullable();
            $table->foreignId('position_id')->nullable();
            $table->text('description');
            $table->string('salary');
            $table->boolean('is_online');

            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('position_id')->references('id')->on('positions')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
