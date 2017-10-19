<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('category')->default('Top Seller');
            $table->integer('number_order')->unsigned()->default(0);
            $table->string('item_pic_dir')
                ->default('http://www.gracosupply.com/content/images/thumbs/0016985_6398-magnabond-epoxy-paste-qt_250.png')
                ->nullable();
            $table->boolean('visible')->default(true)->nullable();
            $table->timestamps();
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
