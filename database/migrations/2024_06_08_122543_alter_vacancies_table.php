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
            $table->text('responsibilities');
            $table->text('requirements');
            $table->text('conditions');
            $table->text('additional')->nullable();
//            $table->dropColumn('is_fulltime');
            $table->foreignID('experience_id')->nullable();
            $table->foreignID('employment_id')->nullable();
            $table->dropColumn('salary');
            $table->float('lower_salary')->nullable();
            $table->float('higher_salary')->nullable();
            $table->foreignId('image_id')->nullable();

            $table->foreign('image_id')->references('id')->on('images')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('experience_id')->references('id')->on('experiences')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('employment_id')->references('id')->on('employments')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn('responsibilities');
            $table->dropColumn('requirements');
            $table->dropColumn('conditions');
            $table->dropColumn('additional');
            $table->boolean('is_fulltime');
            $table->dropForeign(['employment_id']);
            $table->dropForeign(['experience_id']);
            $table->string('salary')->nullable();
            $table->dropColumn('lower_salary');
            $table->dropColumn('higher_salary');
        });
    }
};
