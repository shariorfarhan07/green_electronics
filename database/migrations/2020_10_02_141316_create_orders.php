<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name');
            $table->text('status')->nullable();
            $table->text('email')->nullable();
            $table->text('message')->nullable();
            $table->decimal('payment',8,2);
            $table->text('bkashnumber')->nullable();
            $table->text('txid')->nullable();
            $table->text('address');
            $table->text('city');
            $table->text('division');
            $table->text('zip');
            $table->text('phone');
            $table->decimal('shipping',8,2);
            $table->decimal('paid',8,2)->nullable();
            $table->decimal('discount',8,2)->nullable();
            $table->date('date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
