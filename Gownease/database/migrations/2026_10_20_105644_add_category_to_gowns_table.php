<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gowns', function (Blueprint $table) {
            $table->string('category')->default('Gown')->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('gowns', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};