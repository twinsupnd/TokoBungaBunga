<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Only create the table if it doesn't already exist. This makes the migration
        // safe to run on databases where the table may have been created manually
        // or by previous unfinished migrations.
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('order_number')->unique();
                $table->string('status')->default('pending');
                $table->string('name')->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->bigInteger('total')->default(0);
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
