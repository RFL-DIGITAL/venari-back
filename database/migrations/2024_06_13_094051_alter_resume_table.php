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
        Schema::table('resumes', function (Blueprint $table) {
            $table->string("contact_phone")->nullable();
            $table->string("contact_mail")->nullable();
            $table->string("salary")->nullable();

            $table->foreignId('specialization_id')->nullable();
            $table->foreignId('position_id')->nullable();
            $table->foreignId('employment_id')->nullable();
            $table->foreignId('format_id')->nullable();

            $table->foreign('employment_id')->references('id')->on('employments')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('format_id')->references('id')->on('formats')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('specialization_id')->references('id')->on('specializations')
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
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn("contact_phone");
            $table->dropColumn("contact_mail");
            $table->dropColumn("salary");
            $table->dropForeign(['specialization_id']);
            $table->dropForeign(['position_id']);
        });
    }
};
