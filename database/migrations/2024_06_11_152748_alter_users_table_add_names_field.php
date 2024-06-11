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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name')->nullable();
            $table->foreignId('preview_id')->nullable();
            $table->foreignId('company_id')->nullable();

            $table->foreign("preview_id")->references("id")->on("preview")
                ->onDelete("set null")->onUpdate("cascade");
            $table->foreign("company_id")->references("id")->on("companies")
                ->onDelete("set null")->onUpdate("cascade");
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['preview_id']);
            $table->dropForeign(['company_id']);
        });
    }
};
