<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('Name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('slug')->nullable();
            $table->string('sdescription',300)->nullable();
            $table->text('datasheet')->nullable();
            $table->text('link')->nullable();
            $table->bigInteger('sold');
            $table->bigInteger('stock');
            $table->decimal('price', 10, 2);
            $table->string('type1',100)->nullable();
            $table->string('type2',100)->nullable();
            $table->string('type3',100)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
