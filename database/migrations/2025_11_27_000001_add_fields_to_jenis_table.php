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
        Schema::table('jenis', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('slug')->nullable()->after('name')->unique();
            $table->string('image')->nullable()->after('slug');
            $table->string('price')->nullable()->after('image');
            $table->text('description')->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis', function (Blueprint $table) {
            $table->dropColumn(['name', 'slug', 'image', 'price', 'description']);
        });
    }
};
