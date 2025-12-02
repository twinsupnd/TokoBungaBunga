<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds nullable `created_at` and `updated_at` columns to `orders` if they do not exist.
     */
    public function up()
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (! Schema::hasColumn('orders', 'created_at')) {
                    $table->timestamp('created_at')->nullable()->after('paid_at');
                }
                if (! Schema::hasColumn('orders', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable()->after('created_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'updated_at')) {
                    $table->dropColumn('updated_at');
                }
                if (Schema::hasColumn('orders', 'created_at')) {
                    $table->dropColumn('created_at');
                }
            });
        }
    }
};
