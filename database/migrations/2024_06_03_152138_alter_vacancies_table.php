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
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
            $table->foreignId('department_id')->nullable();
            $table->boolean('has_social_support');
            $table->string('schedule');
            $table->boolean('is_flexible');
            $table->string('link_to_test_document')->nullable();
            $table->boolean('is_fulltime');
            $table->foreignId('city_id')->nullable();

            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')->onDelete('set null');
            $table->dropForeign(['department_id']);
            $table->dropColumn('has_social_support');
            $table->dropColumn('schedule');
            $table->dropColumn('is_flexible');
            $table->dropColumn('link_to_test_document');
            $table->dropColumn('is_fulltime');
            $table->dropForeign(['city_id']);
        });
    }
};
