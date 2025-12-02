<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('orders') && ! Schema::hasColumn('orders', 'phone')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('name');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'phone')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('phone');
            });
        }
    }
};
