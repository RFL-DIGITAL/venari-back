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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('nick_name');
            $table->foreignId('building_id')->nullable();
            $table->foreignId('preview_id')->nullable();

            $table->foreign('preview_id')->references('id')->on('images')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('building_id')->references('id')->on('buildings')
                ->onUpdate('cascade')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('nick_name');
            $table->dropForeign(['building_id']);
            $table->dropForeign(['preview_id']);
        });
    }
};
