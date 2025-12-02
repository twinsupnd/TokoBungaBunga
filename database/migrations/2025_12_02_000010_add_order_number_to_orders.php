<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add missing columns if orders table exists but was created before our migrations
        if (Schema::hasTable('orders')) {
            if (! Schema::hasColumn('orders', 'order_number')) {
                Schema::table('orders', function (Blueprint $table) {
                    // add as nullable initially to avoid migration failure on existing rows
                    $table->string('order_number')->nullable()->after('user_id');
                });
            }

            if (! Schema::hasColumn('orders', 'total')) {
                Schema::table('orders', function (Blueprint $table) {
                    $table->bigInteger('total')->default(0)->after('address');
                });
            }

            if (! Schema::hasColumn('orders', 'paid_at')) {
                Schema::table('orders', function (Blueprint $table) {
                    $table->timestamp('paid_at')->nullable()->after('total');
                });
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'paid_at')) {
                    $table->dropColumn('paid_at');
                }
                if (Schema::hasColumn('orders', 'total')) {
                    $table->dropColumn('total');
                }
                if (Schema::hasColumn('orders', 'order_number')) {
                    $table->dropUnique(['order_number']);
                    $table->dropColumn('order_number');
                }
            });
        }
    }
};
