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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->datetime('datetime_start');
            $table->datetime('datetime_end');
            $table->foreignId('calendar_id')->nullable();
            $table->string('meet_link')->nullable();
            $table->string('title');
            $table->string('g_event_id')->nullable();

            $table->foreign('calendar_id')->references('id')->on('calendars')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
