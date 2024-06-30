<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zones', static function (Blueprint $table) {
            $table->integer('price_per_hour')->change();
        });
    }

    public function down(): void
    {
        Schema::table('zones', static function (Blueprint $table) {
            $table->string('price_per_hour')->change();
        });
    }
};
