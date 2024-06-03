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
        Schema::table('users', function (Blueprint $table) {
            $table->nullableMorphs('hrable');
            $table->date('date_of_birth');
            $table->boolean('sex');
            $table->foreignId("workingStatus_id")->nullable();
            $table->foreignId("position_id")->nullable();
            $table->foreignId("images_id")->nullable();


            $table->foreign("images_id")->references("id")->on("images")
                ->onDelete("set null")->onUpdate("cascade");
            $table->foreign("workingStatus_id")->references("id")->on("working_statuses")
                ->onDelete("set null")->onUpdate("cascade");
            $table->foreign("position_id")->references("id")->on("positions")
                ->onDelete("set null")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('hrable_type');
            $table->dropColumn('hrable_id');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('sex');
            $table->dropForeign(['images_id']);
            $table->dropForeign(['workingStatus_id']);
            $table->dropForeign(['position_id']);
        });
    }
};
