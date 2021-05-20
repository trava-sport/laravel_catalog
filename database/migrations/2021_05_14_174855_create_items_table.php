<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('image')->nullable();
            $table->double('price')->default(0);
            $table->Integer('size_id')->unsigned();
            $table->Integer('fabric_id')->unsigned();
            $table->timestamps();

            $table->foreign('size_id')->references('id')->on('sizes');
            $table->foreign('fabric_id')->references('id')->on('fabrics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
