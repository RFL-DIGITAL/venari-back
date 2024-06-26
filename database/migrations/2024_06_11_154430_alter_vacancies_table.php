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
        Schema::table('vacancies', function (Blueprint $table) {
            $table->string("additional_title")->nullable();
            $table->dateTime("unarchived_at")->default(now());

            $table->foreignId('format_id')->nullable();
            $table->foreignId('accountable_id')->nullable();
            $table->foreignId('status_id')->nullable();
            $table->foreignId('specialization_id')->nullable();

            $table->foreign('specialization_id')->references('id')->on('specializations')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('format_id')->references('id')->on('formats')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('accountable_id')->references('id')->on('hrs')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn("additional_title");
            $table->dropColumn("unarchived_at");
            $table->dropForeign(["specialization_id"]);
            $table->dropForeign(["format_id"]);
            $table->dropForeign(["accountable_id"]);
            $table->dropForeign(["status_id"]);
        });
    }
};
