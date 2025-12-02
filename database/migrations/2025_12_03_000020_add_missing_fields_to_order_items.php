<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (! Schema::hasColumn('order_items', 'jenis_id')) {
                    $table->unsignedBigInteger('jenis_id')->nullable()->after('order_id');
                }
                if (! Schema::hasColumn('order_items', 'name')) {
                    $table->string('name')->nullable()->after('jenis_id');
                }
                if (! Schema::hasColumn('order_items', 'subtotal')) {
                    $table->bigInteger('subtotal')->default(0)->after('quantity');
                }
                if (! Schema::hasColumn('order_items', 'created_at') || ! Schema::hasColumn('order_items', 'updated_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (Schema::hasColumn('order_items', 'subtotal')) {
                    $table->dropColumn('subtotal');
                }
                if (Schema::hasColumn('order_items', 'name')) {
                    $table->dropColumn('name');
                }
                if (Schema::hasColumn('order_items', 'jenis_id')) {
                    $table->dropColumn('jenis_id');
                }
                // Do not drop existing `flower_id` which may be used elsewhere.
            });
        }
    }
};
