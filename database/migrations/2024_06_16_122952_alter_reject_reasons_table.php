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
        Schema::table('reject_reasons', function (Blueprint $table) {
            $table->dropColumn('text');
            $table->string('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reject_reasons', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('text')->nullable();
        });
    }
};
