<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('jenis_id')->nullable();
                $table->string('name');
                $table->bigInteger('price')->default(0);
                $table->integer('quantity')->default(1);
                $table->bigInteger('subtotal')->default(0);
                $table->timestamps();

                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
