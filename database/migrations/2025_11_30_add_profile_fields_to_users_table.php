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
            $table->string('gender')->nullable()->after('email');
            $table->string('last_name')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email_verified_at');
            $table->text('address')->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('address');
            $table->string('location')->nullable()->after('date_of_birth');
            $table->string('postal_code')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'last_name',
                'phone',
                'address',
                'date_of_birth',
                'location',
                'postal_code',
            ]);
        });
    }
};
